<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionUserService;
use App\Traits\RestApiResponseTrait;
use Illuminate\Http\Request;

class SubscriptionUserController extends Controller
{
    use RestApiResponseTrait;
    public function __construct(protected SubscriptionUserService $subscriptionUserService)
    {
    }


    public function store(Request $request)
    {
        $subscriptionUser = $request->only(['first_name', 'last_name', 'email', 'user_type_id']);
        return $this->success('api response', $subscriptionUser, 201);
    }
}
