<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('subscription.index',[
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription): View
    {
        return view('subscription.edit',['subscription' => $subscription]);
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
    public function destroy(Subscription $subscription):RedirectResponse
    {
        $subscription->delete();
        return redirect(route('subscription.manage'))->with('message','Successfully deleted');
    }
}
