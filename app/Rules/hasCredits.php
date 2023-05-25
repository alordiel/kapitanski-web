<?php

namespace App\Rules;

use App\Models\Order;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class hasCredits implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $order = Order::find($value);
        if ($order->credits <= $order->used_credits) {
            $fail(__('This order does not have unused credits!'));
        }
    }
}
