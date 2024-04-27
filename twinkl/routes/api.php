<?php

use App\Http\Controllers\SubscriptionUserController;
use App\Http\Middleware\EnsureIpAddressIsValid;
use Illuminate\Support\Facades\Route;

Route::post('/subscription_user',[SubscriptionUserController::class, 'store'])->middleware(EnsureIpAddressIsValid::class);
