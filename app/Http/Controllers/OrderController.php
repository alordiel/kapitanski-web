<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $isSingle = empty($request->input('students'));
        // check if current user is logged in / has account
        $user = Auth::user();
        if ($user === null) {
            // crete new user
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $role = $isSingle ? 'active-member' : 'partner';
            $user->assignRole($role);

            event(new Registered($user));

            Auth::login($user);
        }
        // TODO: proceed payment
        $credits = $isSingle ? 1 : (int)$request->input('students');
        $singlePrice = $isSingle ? 49 : 39;
        // store the order
        $orderFields = [
            'user_id' => $user->id,
            'credits' => $credits,
            'single_price' => $singlePrice,
            'total' => $singlePrice * $credits,
            'order_status' => 'confirmed',
            'payment_id' => 1,
            'payment_method' => 'paysera',
            'invoice_number' => 0
        ];
        $order = Order::create($orderFields);

        // if it is a single plan purchase - create a subscription
        if ($isSingle) {
            $subscription = new Subscription([
                'exam_id' => 1, // Currently we have only one exam
                'user_id' => $user->id,
                'created_by' => $user->id,
                'order_id' => $order->id,
                'expires_on' => date('Y-m-d', strtotime('+31 days'))
            ]);
            $subscription->save();
        }
        return redirect(route('dashboard'))->with('message', __('Your order was successfully created'));
    }

    /**
     * Display the specified resource.
     */
    public function adminStore(Request $request): RedirectResponse
    {
          // store the order
        $data = $request->validate([
            'user_id' => ['required'],
            'credits' => ['required'],
            'single_price' => ['required'],
            'order_status' => ['required'],
            'payment_id' => ['required'],
            'payment_method' => ['required'],
        ]);
        $data['invoice_number'] = 'hellborn';
        $data['total'] = (int)$request->input('credits') * (int)$request->input('single_price');

        Order::create($data);

        return redirect(route('order.manage'))->with('message','Order created');
    }

        /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('order.index', [
            'orders' => Order::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
       return view('order.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View
    {
        return view('order.edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'credits' => ['required'],
            'single_price' => ['required'],
            'order_status' => ['required'],
            'payment_id' => ['required'],
            'payment_method' => ['required'],
        ]);

        $data['invoice_number'] = 'hellborn';
        $data['total'] = (int)$request->input('credits') * (int)$request->input('single_price');
        $data['id'] = $order->id;
        $data['user_id'] = $order->user_id;
        $order->update($data);

        return back()->with('message','Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        // TODO May be delete subscriptions as well?
        $order->delete();
        return redirect(route('order.manage'))->with('message', 'Deleted successfully');
    }
}
