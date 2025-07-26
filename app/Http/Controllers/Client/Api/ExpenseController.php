<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoresRequest;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Service\expenses\ExpenseService;
use App\Models\Box;
use App\Models\Expense;
use App\Models\CategoryExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExpenseController extends Controller
{
    private $expense;

    public function __construct(ExpenseService $expenses)
    {
        return $this->expense = $expenses;
    }

    public function store_box(Request $request)
    {
        return $this->expense->store_box($request);
    }

    public function getAllBoxes()
    {
        return $this->expense->getAllBoxes();
    }

    //Expenses 

    public function store(ExpenseRequest $request)
    {

        return $this->expense->store($request);
    }


    public function index()
    {
        return $this->expense->index();
    }

    public function delete(Expense  $expense)
    {

        return $this->expense->delete($expense);
    }
    public function update(ExpenseRequest $request, Expense  $expense)
    {
        return $this->expense->update($request, $expense);
    }



    // categores


    public function create_category(CategoresRequest $request)
    {
        return $this->expense->create_category($request);
    }
    public function update_category(CategoresRequest $request, CategoryExpense $category)
    {
        return $this->expense->update_category($request, $category);
    }
    public function categores()
    {
        return $this->expense->categores();
    }

    public function delete_category(CategoryExpense $category)
    {
        return $this->expense->delete_category($category);
    }
}
