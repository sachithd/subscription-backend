<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionUserControllerTest extends TestCase
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

    public function testSubscriptionUserCreate(): void
    {
        $response = $this->postJson('/api/subscription_user', [
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'email' => $this->faker->email(),
                'user_type_id' => rand(1, 4)
            ]
        );

        $response
            ->assertStatus(201)
            ->assertJson([
                'status' => 'success',
            ]);
    }

    public function testInputValidationBlank()
    {
        $response = $this->postJson('/api/subscription_user', [
                'first_name' => null,
                'last_name' => null,
                'email' => null,
                'user_type_id' => null
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
            ]);
    }

    public function testInputValidationSpecialCharacter(): void
    {
        $response = $this->postJson('/api/subscription_user', [
                'first_name' => '$achith',
                'last_name' => $this->faker->lastName(),
                'email' => $this->faker->email(),
                'user_type_id' => rand(1, 4)
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' =>  "Validation Error",
            ]);
    }

    public function testInputValidationEmail()
    {
        $response = $this->postJson('/api/subscription_user', [
                'first_name' => $this->faker->firstName(),
                'last_name' => $this->faker->lastName(),
                'email' => 'invalid email format',
                'user_type_id' => rand(1, 4)
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' =>  "Validation Error",
            ]);
    }
}
