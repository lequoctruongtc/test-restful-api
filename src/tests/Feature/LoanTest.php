<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_list_own_loan()
    {
        $user = User::factory()->create(['email' => 'example@gmail.com']);
        $this->actingAs($user);

        $response = $this->getJson('/api/v1/loans');

        $response->assertOk()->assertJsonStructure([
            'data' => [
                'loans'
            ]
        ]);
    }

    public function test_user_create_loan_success()
    {
        $this->actingAs(User::factory()->create(['email' => 'example@gmail.com']));

        $response = $this->postJson('/api/v1/loans',
            [
                'amount' => 100000,
                'term' => 1,
                'term_type' => 'years',
            ]
        );

        $response->assertOk()->assertJson(['message' => 'Loan has been created successful'])
        ->assertJsonStructure([
            "data" => [
                'id',
                'amount',
                'term',
                'term_type',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);

        $this->assertCount(1, Loan::all());
    }

    public function test_user_create_loan_validation()
    {
        $this->actingAs(User::factory()->create(['email' => 'example@gmail.com']));

        $response = $this->postJson('/api/v1/loans',
            [
                'amount' => '',
                'term' => '',
                'term_type' => '',
            ]
        );

        $response->assertStatus(422)->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "amount" => ["The amount field is required."],
                "term" => ["The term field is required."],
                "term_type" => ["The term type field is required."],
            ]
        ]);
    }

    public function test_user_can_see_detail_own_loan()
    {
        $user = User::factory()->create(['email' => 'example@gmail.com']);
        $this->actingAs($user);

        $loan = Loan::factory()->create([
            'user_id' => $user->id,
            'amount' => 100000,
            'term' => 1,
            'term_type' => 'years',
            'status' => 'pending',
        ]);

        $response = $this->getJson("/api/v1/loans/{$loan->id}");

        $response->assertOk()->assertJsonStructure([
            "data" => [
                'id',
                'amount',
                'term',
                'term_type',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
