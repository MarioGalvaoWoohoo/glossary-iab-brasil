<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PaidInstallmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            // 'expense_id' => $this->expense_id,
            'installment_number' => $this->installment_number,
            'date_paid' => $this->date_paid->format('Y-m-d'),
            'value_paid' => $this->value_paid,
        ];
    }
}
