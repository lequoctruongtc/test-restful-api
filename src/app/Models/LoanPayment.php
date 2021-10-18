<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    use HasFactory;

    const PROCESSING = 'processing';
    const DONE = 'done';

    protected $fillable = [
        'loan_id',
        'amount',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];
}
