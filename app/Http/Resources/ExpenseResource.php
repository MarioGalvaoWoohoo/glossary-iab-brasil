<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => $this->category,
            'date' => $this->date->format('Y-m-d'),
            'value' => $this->value,
            'description' => $this->description,
            'payment_method' => $this->payment_method,
            'location' => $this->location,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'person_to_pay' => $this->person_to_pay,
            'payment_status' => $this->payment_status,
            'installments' => $this->installments,
            'paid_installments' => PaidInstallmentResource::collection($this->paidInstallments),
        ];
    }
}
