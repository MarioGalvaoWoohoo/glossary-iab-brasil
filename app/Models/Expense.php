<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'date',
        'value',
        'description',
        'payment_method',
        'location',
        'start_date',
        'end_date',
        'person_to_pay',
        'payment_status',
        'installments',
    ];

    protected $casts = [
        'date' => 'date',
        'value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function paidInstallments()
    {
        return $this->hasMany(PaidInstallment::class);
    }
}
