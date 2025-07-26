<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'value' => $this->value,
            'student_id' => $this->student_id,
            'student_name' => $this->student?->full_name,
            'school_id' => $this->school_id,
            'school_name' => $this->school?->title,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
