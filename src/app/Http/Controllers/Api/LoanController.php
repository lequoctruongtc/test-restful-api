<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Resources\LoanCollection;
use App\Http\Resources\LoanPaymentCollection;
use App\Http\Resources\LoanResource;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    private $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index()
    {
        $loans = $this->loanService->paginate();
        $resources = new LoanCollection($loans);

        return $resources;
    }

    public function store(StoreLoanRequest $request)
    {
        $data = $request->validated();
        $loan = $this->loanService->create($data);
        $resource = new LoanResource($loan);

        return response()->json([
            'message' => 'Loan has been created successful',
            'data' => $resource
        ]);
    }

    public function show($id)
    {
        $loan = $this->loanService->findOrFail($id);
        $resource = new LoanResource($loan);

        return $resource;
    }
}
