<?php 


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\School;

class SchoolSeeder extends Seeder {
    public function run(): void
    {
        // أولًا: نحصل على شجرة الحسابات الأصلية بدون school_id
        $templateAccounts = Account::whereNull('school_id')->get();

        // ننشئ 10 مدارس وننسخ لكل وحدة الشجرة
        School::factory(10)->create()->each(function ($school) use ($templateAccounts) {
            // داخل تكرار المدرسة ننسخ الشجرة باستخدام transaction
            DB::transaction(function () use ($school, $templateAccounts) {
                $idMap = [];

                foreach ($templateAccounts as $account) {
                    $newAccount = $account->replicate(['school_id', 'created_at', 'updated_at']);
                    $newAccount->school_id = $school->id;

                    if ($account->parent_id) {
                        $newAccount->parent_id = $idMap[$account->parent_id] ?? null;
                    }

                    $newAccount->save();

                    $idMap[$account->id] = $newAccount->id;
                }
            });
        });
    }
}
