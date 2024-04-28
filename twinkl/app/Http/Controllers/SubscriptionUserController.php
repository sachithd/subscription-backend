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
        //TODO Validate Input
        $subscriptionUser = $request->only(['first_name', 'last_name', 'email', 'user_type_id']);

        $createSubscriptionUserResponse = $this->subscriptionUserService->createSubscriptionUserAndEmail($subscriptionUser);

        if ($createSubscriptionUserResponse['error']) {
            return $this->error($createSubscriptionUserResponse['message']);
        }

        return $this->success($createSubscriptionUserResponse['message'], $createSubscriptionUserResponse['data'], 201);
    }
}
