<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const APPROVED = 'approved';

    protected $fillable = [
        'user_id',
        'amount',
        'term',
        'term_type',
        'status',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function loanPayments()
    {
        return $this->hasMany(LoanPayment::class);
    }
}
