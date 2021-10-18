<?php

namespace Tests\Feature;

use App\Models\LoanPayment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanPaymentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_list_loan_payment()
    {
        $user = User::factory()->create(['email' => 'example@gmail.com']);
        $this->actingAs($user);
        $response = $this->getJson('/api/v1/loan-payments');

        $response->assertStatus(200);
    }

    public function test_user_can_see_detail_loan_payment()
    {
        $user = User::factory()->create(['email' => 'example@gmail.com']);
        $this->actingAs($user);

        $loanPayment = LoanPayment::factory()->create([
            'loan_id' => 1,
            'amount' => 100,
            'start_at' => now(),
            'end_at' => now()->addMonth(),
            'status' => 'processing',
        ]);

        $response = $this->getJson("/api/v1/loan-payments/{$loanPayment->id}");

        $this->assertEquals(100, $response->json()['data']['amount']);
    }

    public function test_user_pay_one_loan_payment_success()
    {
        $user = User::factory()->create(['email' => 'example@gmail.com']);
        $this->actingAs($user);

        $loanPayment = LoanPayment::factory()->create([
            'loan_id' => 1,
            'amount' => 100,
            'start_at' => now(),
            'end_at' => now()->addMonth(),
            'status' => 'processing',
        ]);

        $response = $this->patchJson("/api/v1/loan-payments/{$loanPayment->id}/pay", ['amount' => 100]);

        $loanPayment->refresh();

        $this->assertEquals('done', $loanPayment->status);
    }

    public function test_user_pay_one_loan_payment_fail()
    {
        $user = User::factory()->create(['email' => 'example@gmail.com']);
        $this->actingAs($user);

        $loanPayment = LoanPayment::factory()->create([
            'loan_id' => 1,
            'amount' => 100,
            'start_at' => now(),
            'end_at' => now()->addMonth(),
            'status' => 'processing',
        ]);

        $response = $this->patchJson("/api/v1/loan-payments/{$loanPayment->id}/pay", ['amount' => 101]);

        $loanPayment->refresh();

        $this->assertEquals('done', $loanPayment->status);
    }

    public function test_user_pay_one_loan_payment_validation()
    {
        $user = User::factory()->create(['email' => 'example@gmail.com']);
        $this->actingAs($user);

        $loanPayment = LoanPayment::factory()->create([
            'loan_id' => 1,
            'amount' => 100,
            'start_at' => now(),
            'end_at' => now()->addMonth(),
            'status' => 'processing',
        ]);

        $response = $this->patchJson("/api/v1/loan-payments/{$loanPayment->id}/pay", ['amount' => '']);

        $loanPayment->refresh();

        $this->assertEquals('done', $loanPayment->status);
    }
}
