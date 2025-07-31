<?php

namespace App\Http\Resources\result;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *    "id": 2,
    
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[

            'id'=>$this->id,
            'student_id'=>$this->when($request->routeIs('results.show'),$this->student_id),
            'student'=>$this->student?->full_name,
            'subjects'=>$this->when($request->routeIs('results.show'),$this->subjects),
            'type_exam'=>$this->when($request->routeIs('results.show'),$this->type_exam),
   

        ];
    }
}
