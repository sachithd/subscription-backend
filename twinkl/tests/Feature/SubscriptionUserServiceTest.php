<?php

namespace Tests\Feature;

use App\Repositories\SubscriptionUserRepository;
use App\Repositories\SubscriptionUserRepositoryInterface;
use App\Services\SubscriptionUserService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionUserServiceTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCreateSubscriptionUserAndEmail(): void{
        $user = array(
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'email' => $this->faker->email(),
                'user_type_id' => rand(1, 4),
                'email_reminder' => 0
        );

        $service = new SubscriptionUserService(new SubscriptionUserRepository());
        $actualResult = $service->createSubscriptionUserAndEmail($user);

        $expectedResult = array(
            "error" => false,
            "message" => 'subscription user created successfully',
        );

        $this->assertEquals($expectedResult['error'],$actualResult['error'] );
        $this->assertEquals($expectedResult['message'],$actualResult['message'] );

    }

}
