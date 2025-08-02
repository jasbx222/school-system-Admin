<?php

namespace App\Http\Controllers\Schools\v1\intallments;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstallmentRequest;
use App\Http\Service\intallments\InstallmentService;
use App\Models\Installment;
use App\Models\Student as ModelsStudent;

class InstallmentController extends Controller
{
    //الاقساط



    private $ins;
    public function __construct(InstallmentService $installment)
    {
        $this->ins = $installment;
    }



    //get all installment
    public function index()
    {
        return $this->ins->index();
    }



    //create new   installment with parts 
    public function store(InstallmentRequest $request)
    {
        return $this->ins->store($request);
    }



     //this function toggale the status of paid 
    public function update( Installment $installment)
    {
        return $this->ins->update( $installment);
    }



  //get one  installment
    public function show($id)
    {
        return $this->ins->show($id);
    }


      //delete   installment
    public function destroy(Installment $installment)
    {
        return $this->ins->delete($installment);
    }



    public function getInstallmentsStudent( $id)
    {

        return $this->ins->getInstallmentsStudent($id);
    }
    


    public function getAllInsSum(){
         return $this->ins->getAllInsSum();
    }

    
//جلب كل الاقساط الدفوعة
public function getAllInsPaid(){
      return $this->ins->getAllInsPaid();
}



//جلب كل الاقساط الغير مدفوعة
public function getAllInsPending(){
     return $this->ins->getAllInsPending();
}
}
