<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayLoanPaymentRequest;
use App\Http\Resources\LoanPaymentCollection;
use App\Http\Resources\LoanPaymentResource;
use App\Services\LoanPaymentService;

class LoanPaymentController extends Controller
{
    private $paymentService;

    public function __construct(LoanPaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $loanPayments = $this->paymentService->paginate();
        $resources = new LoanPaymentCollection($loanPayments);

        return $resources;
    }

    public function show($id)
    {
        $loanPayment = $this->paymentService->findOrFail($id);
        $resource = new LoanPaymentResource($loanPayment);

        return $resource;
    }

    public function pay(PayLoanPaymentRequest $request, $id)
    {
        $data = $request->validated();
        $this->paymentService->pay($data, $id);

        return response()->json(['message' => 'Payment successful']);
    }
}
