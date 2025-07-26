<div class="p-4">
    <h2 class="text-xl font-bold mb-4">قائمة الطلاب</h2>

    <table class="w-full border-collapse border border-gray-300 text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">ID</th>
                <th class="border p-2">الاسم الكامل</th>
                <th class="border p-2">اسم الأم</th>
                <th class="border p-2">المدرسة</th>
                <th class="border p-2">الجنس</th>
                <th class="border p-2">يتيم؟</th>
                <th class="border p-2">أقارب شهداء؟</th>
                <th class="border p-2">تاريخ الميلاد</th>
                <th class="border p-2">الوصف</th>
                <th class="border p-2">الصورة</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td class="border p-2 text-center">{{ $student->id }}</td>
                    <td class="border p-2">{{ $student->full_name }}</td>
                    <td class="border p-2">{{ $student->mother_name }}</td>
                    <td class="border p-2">{{ $student->school_id }}</td>
                    <td class="border p-2">{{ $student->gender }}</td>
                    <td class="border p-2">{{ $student->orphan ? 'نعم' : 'لا' }}</td>
                    <td class="border p-2">{{ $student->has_martyrs_relatives ? 'نعم' : 'لا' }}</td>
                    <td class="border p-2">{{ $student->birth_day }}</td>
                    <td class="border p-2">{{ $student->description }}</td>
                    <td class="border p-2">
                        @if ($student->profile_image_url)
                            <img src="{{ $student->profile_image_url }}" alt="صورة" class="w-12 h-12 object-cover rounded-full">
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center p-4">لا توجد بيانات</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
