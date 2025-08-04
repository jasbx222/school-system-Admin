<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = json_decode(File::get(database_path('seeders/chart_of_accounts.json')), true);

        foreach ($accounts['accounts'] as $account) {
            $this->createAccount($account);
        }
    }

    private function createAccount(array $data, $parentId = null): void
    {
        $account = Account::create([
            'code' => $data['code'],
            'name' => $data['name'],
            'parent_id' => $parentId,
        ]);

        if (isset($data['children'])) {
            foreach ($data['children'] as $child) {
                $this->createAccount($child, $account->id);
            }
        }
    }
}
