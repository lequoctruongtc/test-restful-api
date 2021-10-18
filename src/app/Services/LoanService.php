<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\LoanPayment;
use Carbon\CarbonPeriod;

class LoanService extends Service
{
    public function setModel()
    {
        return Loan::class;
    }

    public function create(array $data)
    {
        $data['user_id'] = auth()->id();
        return $this->model->create($data);
    }

    public function approve($id)
    {
        $loan = $this->findOrFail($id);
        if ($loan->status === Loan::APPROVED) {
            abort(400, "This loan has been approve");
        }
        $start = now();
        $end = $start->copy()->add($loan->term_type, $loan->term);
        $duration = '1 weeks';
        $data = $this->calculateLoanPayment($loan, $start, $end, $duration);

        $loanPayments = $loan->loanPayments()->createMany($data);
        $loan->status = Loan::APPROVED;
        $loan->save();
        return $loanPayments;
    }

    public function calculateLoanPayment($loan, $start, $end, $duration)
    {
        $data = [];
        $period = CarbonPeriod::create($start, $duration, $end, CarbonPeriod::EXCLUDE_START_DATE);
        $amount = ($loan->amount/$period->count());
        foreach ($period as $date) {
            $data[] = [
                'loan_id' => $loan->id,
                'amount' => round($amount, 2),
                'start_at' => $date->subWeek()->format('d-m-Y'),
                'end_at' => $date->format('d-m-Y'),
                'status' => LoanPayment::PROCESSING,
            ];
        }

        return $data;
    }
}
