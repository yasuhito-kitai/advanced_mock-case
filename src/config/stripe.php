<?php

return [
    'public_key' => env('STRIPE_KEY'),
    'secret_key' => env('STRIPE_SECRET'),
    'price_id' => env('STRIPE_PRICE_ID'),
];
