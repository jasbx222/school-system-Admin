<?php
namespace App\Http\Controllers\Schools\v1\account;

use App\Http\Controllers\Controller;
use App\Models\Account;

class AccountController extends Controller
{
    // This controller will handle account-related operations
    // such as creating, updating, and retrieving accounts.
    
    public function index()
{
    $accounts = Account::whereNull('parent_id')->with('childrenRecursive')->get();
    return response()->json($accounts);
}


   

   
}