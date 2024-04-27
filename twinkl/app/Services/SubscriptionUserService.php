<?php

namespace App\Services;

use App\Repositories\SubscriptionUserRepositoryInterface;

class SubscriptionUserService
{
    public function __construct(protected SubscriptionUserRepositoryInterface $repository) {
    }
}
