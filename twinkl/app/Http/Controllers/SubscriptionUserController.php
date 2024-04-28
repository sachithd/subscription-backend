<?php

namespace App\Http\Controllers;

use App\Services\SubscriptionUserService;
use App\Traits\RestApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionUserController extends Controller
{
    use RestApiResponseTrait;
    public function __construct(protected SubscriptionUserService $subscriptionUserService)
    {
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255|regex:/^[A-Za-z0-9 ]+$/',
            'last_name' => 'required|max:255|regex:/^[A-Za-z0-9 ]+$/',
            'email' => 'required|email|unique:subscription_users|max:255',
            'user_type_id' => 'required|exists:subscription_user_types,id',
        ]);

        if ($validator->fails()) {
            return $this->error("Validation Error", $validator->errors(), 422);
        }

        $subscriptionUser = $request->only(['first_name', 'last_name', 'email', 'user_type_id']);

        $createSubscriptionUserResponse = $this->subscriptionUserService->createSubscriptionUserAndEmail($subscriptionUser);

        if ($createSubscriptionUserResponse['error']) {
            return $this->error($createSubscriptionUserResponse['message']);
        }

        return $this->success($createSubscriptionUserResponse['message'], $createSubscriptionUserResponse['data'], 201);
    }
}
