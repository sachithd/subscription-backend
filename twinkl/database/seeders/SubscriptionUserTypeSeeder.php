<?php

namespace Database\Seeders;

use App\Enums\SubscriptionUserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionUserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscription_user_types')->insert([
            ['user_type' => SubscriptionUserType::STUDENT],
            ['user_type' => SubscriptionUserType::TEACHER],
            ['user_type' => SubscriptionUserType::PARENT],
            ['user_type' => SubscriptionUserType::PRIVATE_TUTOR]
        ]);
    }
}
