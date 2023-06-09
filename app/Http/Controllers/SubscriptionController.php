<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use App\Rules\hasCredits;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('subscription.index', [
            'subscriptions' => Subscription::all()
        ]);
    }

    public function showPersonal(): View
    {
        return view('subscription.personal');
    }

    public function manageStudents(Order $order): View
    {
        return view('subscription.manageStudents', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'created_at' => 'required',
            'exam_id' => 'required',
            'expires_on' => 'required',
            'user_id' => ['required'],
            'order_id' => ['required', new hasCredits],
        ]);

        $data['created_by'] = Auth::user()->id;
        // TODO we should not be able to create a subscription on orders that don't have more available space
        Subscription::create($data);

        // Update the order with the used credit for this subscription
        $order = Order::find($data['order_id']);
        $order->used_credits++;
        $order->save();

        return redirect(route('subscription.manage'))->with('message', 'Successfully created');
    }

    public function storeStudents(Request $request): RedirectResponse
    {

        // Validate the order that belongs to the same user
        $user = Auth::user();
        $order = Order::find((int)$request->input('orderId'));
        if ($order->user_id !== $user->id) {
            return back()->withErrors(['message' => __('It seems that you are not the owner of this order.')], 'general');
        }

        $numberOfStudents = $request->input('number-of-rows');
        $students = [];
        // since the form is dynamic we need to build an array with all the students
        for ($i = 0; $i < $numberOfStudents; $i++) {
            $index = $i + 1;
            // prevent records of empty rows
            if (empty($request->input('name-' . $index)) && empty($request->input('email-' . $index))) {
                continue;
            }
            $students[] = [
                'name' => $request->input('name-' . $index),
                'email' => $request->input('email-' . $index),
            ];
        }

        // Validate the number of available credits
        if (($order->credits - $order->used_credits) < $numberOfStudents) {
            return back()
                ->withInput($students)
                ->withErrors(['message' => __('It seems that you do not have enough credits.')], 'general');
        }

        $validator = Validator::make($students, [
            '*.name' => ['required', 'string', 'max:255'],
            '*.email' => ['required', 'email']
        ], [
            'email' => __('This seems to be invalid email'),
            'required' => __('This field is required'),
            'max:255' => __('Field can not have more then 255 characters'),
            'string' => __('Field should contain only strings'),
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'form')
                ->withInput($students);
        }

        foreach ($students as $student) {
            // Check if the user doesn't exist already
            $user = User::where('email', $student['email'])->first();
            if ($user === null) {
                $user = User::create([
                    'name' => $student['name'],
                    'email' => $student['email'],
                    'password' => Hash::make(uniqid(true))
                ]);
                $user->syncRoles('member');
                event(new Registered($user));
            }

            // add the subscription
            Subscription::create([
                'exam_id' => 1,
                'created_at' => null,
                'expires_on' => null,
                'user_id' => $user->id,
                'order_id' => $order->id,
                'created_by' => $order->user_id,
            ]);

            $order->used_credits++;
            $order->save();
        }

        return back()->with('message', __('Successfully added'));
    }

    /**
     * Activation of subscription. By default, every user that has an order also has a subscription.
     * The subscription can be unactivated (no started), active (the expiration date is in the future), expired
     * The method below will check if there is inactive subscription and will activate it.
     *
     * @return RedirectResponse
     */
    public function activate(): RedirectResponse
    {
        $user = Auth::user();
        if ($user === null) {
            return back()->with('message', __('You need to login in order to perform this action.'));
        }

        $subscriptions = $user->subscriptions;
        $subscription_activated = false;
        if (!empty($subscriptions)) {
            // check if order has a subscription attached or needs one to be activated
            foreach ($subscriptions as $subscription) {
                // the subscription is considered activated if it has expiration date
                if ($subscription->expires_on !== null) {
                    continue;
                }

                $subscription->expires_on = date('Y-m-d', strtotime('+31 days'));
                $subscription->save();

                // check user role and change it accordingly
                $user_role = $user->getRoleNames()->last();
                if ('member' === $user_role) {
                    $user->syncRoles('student');
                } elseif ('partner' === $user_role) {
                    $user->syncRoles('student-partner');
                }

                $subscription_activated = true;
                break;
            }

            if (!$subscription_activated) {
                return back()->with('message', __('Your subscription has expired. You will need to purchase a new one.'));
            }
        } else {

            return back()->with('message', __('No subscription was found. Have you purchased an exam.'));
        }

        return back()->with('message', __('Your subscription was activated. You can proceed with the tests.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription): View
    {
        return view('subscription.edit', ['subscription' => $subscription]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        $data = $request->validate([
            'created_at' => 'required',
            'exam_id' => 'required',
            'expires_on' => 'required'
        ]);
        // Prevent the following values to be updated
        $data['user_id'] = $subscription->user_id;
        $data['created_by'] = $subscription->created_by;
        $data['order_id'] = $subscription->order_id;

        $subscription->update($data);

        return back()->with('message', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        // Let's first update the number of used credits in the order
        $order = Order::find($subscription->order_id);
        $order->used_credits--;
        $order->save();

        $subscription->delete();
        return redirect(route('subscription.manage'))->with('message', 'Successfully deleted');
    }
}
