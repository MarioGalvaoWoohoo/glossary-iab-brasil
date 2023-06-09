<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_id',
        'installment_number',
        'date_paid',
        'value_paid',
    ];

    protected $casts = [
        'date_paid' => 'date',
        'value_paid' => 'decimal:2',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
