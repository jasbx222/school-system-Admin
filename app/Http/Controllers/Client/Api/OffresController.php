<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Http\Resources\OfferResource;
use App\Http\Service\offres\OffresService;
use App\Models\Offer;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class OffresController extends Controller
{
    private $offer;

    public function __construct(OffresService $offers)
    {
        return $this->offer = $offers;
    }

    public function index()
    {

        return $this->offer->index();
    }

    public function store(OfferRequest $request)
    {

        return $this->offer->store($request);
    }

    public function update(OfferRequest $request, Offer $offer)
    {
        return $this->offer->update($request, $offer);
    }
    public function delete(Offer $offer)
    {
        return $this->offer->delete($offer);
    }
}
