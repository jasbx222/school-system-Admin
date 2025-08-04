<?php

namespace App\Http\Resources\receipts;

use Illuminate\Http\Resources\Json\JsonResource;





class ReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account_id' => $this->account->name,
            'amount' => $this->amount,
            'method' => $this->method,
            'receipt_number' => $this->receipt_number,
            'notes' => $this->notes,
            
        ];
    }
}

  
