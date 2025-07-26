<?php

namespace App\Exports;

use App\Enums\Gender;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithStyles
{
    protected $students;
    protected $schoolId;

    public function __construct($students, $schoolId)
    {
        $this->students = $students;
        $this->schoolId = $schoolId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $maleStudents = $this->students->where('gender', Gender::MALE)->count() ?? '0';
        $femaleStudents = $this->students->where('gender', Gender::FEMALE)->count() ?? '0';
        $classRooms = ClassRoom::where('school_id', $this->schoolId)->get();

        $classRoomCounts[] = ['الصفوف'];

        foreach ($classRooms as $classRoom) {
            $studentCount = $this->students->where('class_room_id', $classRoom->id)->count();

            $classRoomCounts[] = ['' => '', '' => ''];
            $classRoomCounts[] = [
                'ClassRoomStudentCount' => ' الصف ' . $classRoom->title,
                'Count' => ($studentCount === 0) ? '0' : (string)$studentCount
            ];

            $classSections = ClassSection::where('class_room_id', $classRoom->id)->get();
            foreach ($classSections as $classSection) {
                $studentCountInSection = $this->students->where('class_section_id', $classSection->id)->count();
                $classRoomCounts[] = [
                    'ClassSectionStudentCount' => 'شعبة  ' . $classSection->title,
                    'Count' => ($studentCountInSection === 0) ? '0' : (string)$studentCountInSection
                ];
            }
        }

        $totalStudentCount = $this->students->count();

        return collect([
            ['StudentCount' => 'عدد الطلاب الكلي', 'Count' => (string)$totalStudentCount],
            ['MaleStudentCount' => 'عدد الذكور', 'Count' => (string)$maleStudents],
            ['FemaleStudentCount' => 'عدد الإناث', 'Count' => (string)$femaleStudents],
        ])->merge($classRoomCounts);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A'    => ['font' => ['bold' => true, 'size' => 12, 'width' => 155]],
        ];
    }
}
