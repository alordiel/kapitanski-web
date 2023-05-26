<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Subscription;
use App\Rules\hasCredits;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function activate(): RedirectResponse
    {
        $user = Auth::user();
        $orders = $user->orders;
        if (!empty($orders)) {
            // check if order has a subscription attached or needs one to be activated
            foreach ($orders as $order) {
                if ($order->credits > $order->used_credits) {
                    $data = [
                        'exam_id' => 1,
                        'user_id' => $user->id,
                        'order_id' => $order->id,
                        'created_by' => $user->id,
                        'expires_on' => date('Y-m-d', strtotime('+31 days')),
                    ];

                    Subscription::create($data);

                    // check user role and change it accordingly
                    $user_role = $user->getRoleNames();
                    if (in_array('member', $user_role, true)) {
                        $user->syncRoles('student');
                    } elseif (in_array('partner', $user_role, true)) {
                        $user->syncRoles('student-partner');
                    }

                    $order->used_credits++;
                    $order->save();
                    break;
                }
            }
        } else {

            return back()->with('message', __('No order was found. Have you purchased an exam.'));
        }
        return back()->with('message', __('Your subscription was activated. You can proceed with the tests'));
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
