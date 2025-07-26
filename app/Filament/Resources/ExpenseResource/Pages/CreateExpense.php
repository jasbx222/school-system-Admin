<?php 

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Enums\Payment;
use App\Filament\Resources\ExpenseResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;

class CreateExpense extends CreateRecord

{
    protected static string $resource = ExpenseResource::class;
    
    protected function afterCreate(): void
    {
        $expense = $this->record;
        $user = Auth::user();
        $school = $user->school; // تأكد أن العلاقة معرفة في موديل User
        $cashBox = $school->box; // تأكد أن العلاقة معرفة في موديل School

        // لو ما موجود صندوق، نسويه جديد مربوط بالمدرسة
        if (!$cashBox) {
            $cashBox = new \App\Models\Box();
            $cashBox->school_id = $school->id;
            $cashBox->amount = 0;
            $cashBox->save();
        }

        if ($expense->status === Payment::GAVE) {
            $cashBox->amount -= $expense->amount;

            Entry::create([
                'box_id' => $cashBox->id,
                'expense_id' => $expense->id,
                'type' => 'credit',
                'amount' => $expense->amount,
                'description' => 'صرف من الصندوق للمصروف #' . $expense->id,
            ]);

        } elseif ($expense->status === Payment::TAKE) {
            $cashBox->amount += $expense->amount;

            Entry::create([
                'box_id' => $cashBox->id,
                'expense_id' => $expense->id,
                'type' => 'debit',
                'amount' => $expense->amount,
                'description' => 'إضافة للصندوق من المصروف #' . $expense->id,
            ]);
        }

        $cashBox->save();
    }
}
