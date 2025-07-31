<?php 
namespace App\Http\Service\offres;

use App\Http\Resources\offers\OfferResource;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;

class OffresService {


    public function index (){
    $schoolId = auth()->user()->school_id;
    $offers = Offer::where('school_id', $schoolId)->get();

    return OfferResource::collection($offers);
    }

    public function store( $request ){

        $data =$request->validated();
        $data ['school_id'] = Auth::user()->school_id;

        Offer::create($data);
        return response()->json(['messaage'=>'تم اضافة الخصم بنجاح '],201);
    }
    
    public function update( $request, $offer ){

        $data =$request->validated();
        $data ['school_id'] = Auth::user()->school_id;

        $offer->update($data);
        return response()->json(['message'=>'تم تعديل الخصم بنجاح ']);
    }
    public function delete( $offer ){

       
        $offer->delete();
        return response()->json(['message'=>'تم حذف الخصم بنجاح ']);
    }



     //get the sum for offers  جلب مجموع الخصومات ككل

    
    public function getAllOfferForSchool()
    {
        $schoolId = auth()->user()->school_id;

        $offers = Offer::where('school_id', $schoolId)->get();
        $total = $offers->sum('value');

        return response()->json([
            'total' => $total,
        ]);
    }
}