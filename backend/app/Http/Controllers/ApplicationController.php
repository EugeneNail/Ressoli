<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Address;
use App\Models\Apartment;
use App\Models\Application;
use App\Models\Client;
use App\Models\House;
use App\Models\LandParcel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApplicationController extends Controller {

    public function store(StoreApplicationRequest $request) {
        $data = $request->safe();
        $client = Client::find($data->client_id);
        $address = Address::find($data->address_id);
        $applicable = $this->getApplicable($request->applicable, $data->applicable_id);

        $application = new Application($data->toArray());
        $application->user()->associate($request->user());
        $application->client()->associate($client);
        $application->address()->associate($address);
        $application->applicable()->associate($applicable);
        $application->save();

        return response()->json($application->id, Response::HTTP_CREATED);
    }

    private function getApplicable(string $applicable, int | string $applicableId): Model {
        $map = [
            "land-parcel" => LandParcel::class,
            "house" => House::class,
            "apartment" => Apartment::class
        ];

        return $map[$applicable]::find($applicableId);
    }
}
