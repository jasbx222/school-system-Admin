<?php
namespace App\Http\Controllers\Schools\v1\account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\PaymentVoucher;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // This controller will handle account-related operations
    // such as creating, updating, and retrieving accounts.
    
    public function index()
{
    $accounts = Account::where('school_id',Auth::user()->school_id)->whereNull('parent_id')->with('childrenRecursive')->get();
    return response()->json($accounts);
}

public function get_profit_loss()
{
    $schoolId = Auth::user()->school_id;

    // جلب حسابات الإيرادات الخاصة بالمدرسة الحالية
    $incomeAccounts = Account::where('school_id', $schoolId)
                            ->where('type', 'income')
                            ->pluck('id')
                            ->toArray();

    // جلب حسابات المصروفات الخاصة بالمدرسة الحالية
    $expenseAccounts = Account::where('school_id', $schoolId)
                            ->where('type', 'expense')
                            ->pluck('id')
                            ->toArray();

    // مجموع الإيرادات للمدرسة فقط
    $income = Receipt::whereIn('account_id', $incomeAccounts)->sum('amount');

    // مجموع المصروفات للمدرسة فقط
    $expenses = PaymentVoucher::whereIn('account_id', $expenseAccounts)->sum('amount');

    $profit = $income - $expenses;

    return response()->json([
        'income' => $income,
        'expenses' => $expenses,
        'profit' => $profit,
    ]);
}


 
   
}