<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function checkout()
    {
        $user = User::find(Auth::user()->id);
        return $user->checkout( config('stripe.price_id'), [
            'success_url' => route('success'),
            'cancel_url' => route('cancel')
        ]);
    }
}
