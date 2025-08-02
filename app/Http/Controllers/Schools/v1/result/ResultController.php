<?php

namespace App\Http\Controllers\Schools\v1\result;

use App\Http\Controllers\Controller;
use App\Http\Requests\result\ResultRequest;
use App\Http\Service\result\ResultService;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
 //النتائج

    private $res;

    public function __construct(ResultService $result)
    {
        $this->res=$result;
    }
    //جلب كل النتائج

    public function index(){
        return $this->res->index();
    }

    //اصدار نتيجة جديدة 
    public function store(ResultRequest $request){
            return $this->res->store($request);
    }
    

    //استعراض نتيجه الطالب 
        public function show(Result $result){
        return $this->res->show($result);
    }
    //تحديث نتيجة معينة
        public function update(ResultRequest $request ,Result $result){
        return $this->res->update($request,$result);
    }
    //حذفها من السيستم 
        public function destroy(Result $result){
        return $this->res->delete($result);
    }
}
