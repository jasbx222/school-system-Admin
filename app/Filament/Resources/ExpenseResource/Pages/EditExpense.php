<?php
namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Enums\Payment;
use App\Filament\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpense extends EditRecord
{
    protected static string $resource = ExpenseResource::class;

    protected $oldAmount;
    protected $oldStatus;

    public function mount($record): void
    {
        parent::mount($record);

        $this->oldAmount = $this->record->amount;
        $this->oldStatus = $this->record->status;
    }

    protected function afterSave(): void
    {
        $expense = $this->record;
        $cashBox = \App\Models\Box::first();

        if (!$cashBox) {
            $cashBox = new \App\Models\Box();
            $cashBox->amount = 0;
        }

        if ($this->oldStatus === Payment::GAVE) {
            $cashBox->amount += $this->oldAmount;
        } elseif ($this->oldStatus === Payment::TAKE) {
            $cashBox->amount -= $this->oldAmount;
        }

        if ($expense->status === Payment::GAVE) {
            $cashBox->amount -= $expense->amount;
        } elseif ($expense->status === Payment::TAKE) {
            $cashBox->amount += $expense->amount;
        }

        $cashBox->save();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
