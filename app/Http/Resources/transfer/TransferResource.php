<?php


namespace App\Http\Resources\transfer;

use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'from_class_room_id' => $this->from_class_room_id,
            'from_class_section_id' => $this->from_class_section_id,
            'to_class_room_id' =>
            $this->to_class_room_id,
            'to_class_section_id' => $this->to_class_section_id,
            'student' => new \App\Http\Resources\students\StudentResource($this->whenLoaded('student')),
        ];
    }


    /**
     * Get the additional data that should be returned with the resource.
     *
     * @return array<string, mixed>
     */
    public function with($request)
    {
        return [
            'meta' => [
                'status' => 'success',
                'message' => 'Student transfer data retrieved successfully',
            ],
        ];
    }
}
