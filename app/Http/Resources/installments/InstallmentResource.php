<?php

namespace App\Http\Resources\installments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
   
   
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'amount' => $this->amount,
            'student' => $this->student->full_name,
            'status' => $this->status,
            'created_at' => $this->created_at?->toDateTimeString(),
            "parts" => InstallmentPartResource::collection($this->parts)

        ];
    }
}
