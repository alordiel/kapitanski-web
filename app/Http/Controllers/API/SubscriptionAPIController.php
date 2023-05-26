<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SubscriptionAPIController extends Controller
{
    public function activate(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user === null) {
            response()->json([
                'status' => 'fail',
                'message' => __('You need to login in order to perform this action.'),
            ], 401);
        }
        $orders = $user->orders;
        $subscription_created = false;
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
                    $subscription_created = true;
                    break;
                }
            }

            if (!$subscription_created) {
                response()->json([
                    'status' => 'fail',
                    'message' => __('No free credits were found. You will need to purchased an exam.'),
                ], 418);
            }

        } else {

            response()->json([
                'status' => 'fail',
                'message' => __('No order was found. Have you purchased an exam.'),
            ], 418);
        }

        response()->json([
            'status' => 'success',
            'message' => __('Your subscription was activated. You can proceed with the tests'),
        ], 201);
    }
}
