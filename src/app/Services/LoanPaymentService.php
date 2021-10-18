<?php

namespace App\Services;

use App\Models\LoanPayment;

class LoanPaymentService extends Service
{
    public function setModel()
    {
        return LoanPayment::class;
    }

    public function pay(array $data, $id)
    {
        $payment = $this->findOrFail($id);
        if ($data['amount'] != $payment->amount) {
            abort(400, "Payment amount not correct");
        }
        $payment->status = LoanPayment::DONE;
        return $payment->save();
    }
}
