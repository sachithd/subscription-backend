<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface SubscriptionUserRepositoryInterface
{
    public function createSubscriptionUser(array $data): int;

    public function getSubscriptionUserById($id): ?Collection;
}
