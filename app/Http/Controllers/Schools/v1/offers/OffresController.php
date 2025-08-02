<?php

namespace App\Http\Controllers\Schools\v1\offers;

use App\Http\Controllers\Controller;
use App\Http\Requests\offers\OfferRequest;
use App\Http\Service\offres\OffresService;
use App\Models\Offer;
class OffresController extends Controller
{
    //الخصومات

    
    private $offer;

    public function __construct(OffresService $offers)
    {
        return $this->offer = $offers;
    }

    //get alll offers
    public function index()
    {

        return $this->offer->index();
    }


    //create new offers

    public function store(OfferRequest $request)
    {

        return $this->offer->store($request);
    }

    //update the offer 



    public function update(OfferRequest $request, Offer $offer)
    {
        return $this->offer->update($request, $offer);
    }

    
    //delete the offer 


    public function delete(Offer $offer)
    {
        return $this->offer->delete($offer);
    }


     //get the sum for offers  جلب مجموع الخصومات ككل

    
    public function getAllOfferForSchool()
    {
        return $this->offer->getAllOfferForSchool();
    }
}
