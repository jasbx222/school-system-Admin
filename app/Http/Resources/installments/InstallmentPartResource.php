<?php

namespace App\Http\Resources\installments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentPartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
   
   
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount'=>$this->amount,
            'due_date'=>$this->due_date?->toDateTimeString(),
            'paid_at'=>$this->due_date?->toDateTimeString(),

        ];
    }
}
