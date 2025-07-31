<?php

namespace App\Http\Resources\students;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'full_name' => $this->full_name,
            'mother_name' => $this->mother_name,
            'school_id' => $this->school_id,
            'profile_image_url' => $this->profile_image_url,
            'file' => $this->file ?? 'لايوجد ملف مرفق',
            'description' => $this->description,
            'status' => $this->status,
            'gender' => $this->gender,
            'orphan' => $this->orphan,
            'has_martyrs_relatives' => $this->has_martyrs_relatives,
            'last_school' => $this->last_school,
            'semester_id' => $this->semester->title,
            'class_room_id' => $this->classRoom->title,
            'class_section_id' => $this->class_section_id,
            'birth_day' => $this->birth_day,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
