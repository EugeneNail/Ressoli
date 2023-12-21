<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
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

    public function store(StoreApplicationRequest $request, string $applicables) {
        $data = $request->safe();
        $client = Client::find($data->client_id);
        $address = Address::find($data->address_id);
        $applicable = $this->getApplicable($applicables, $data->applicable_id);

        $application = new Application($data->toArray());
        $application->user()->associate($request->user());
        $application->client()->associate($client);
        $application->address()->associate($address);
        $application->applicable()->associate($applicable);
        $application->save();

        return response()->json($application->id, Response::HTTP_CREATED);
    }

    public function update(UpdateApplicationRequest $request, string $applicables, Application $application) {
        if ($application === null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $data = $request->safe();
        $client = Client::find($data->client_id);
        $address = Address::find($data->address_id);
        $applicable = $this->getApplicable($applicables, $data->applicable_id);

        $application->client()->associate($client);
        $application->address()->associate($address);
        $application->applicable()->associate($applicable);
        $application->update($data->toArray());
        $application->save();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function getApplicable(string $applicables, int | string $applicableId): Model {
        $modelClasses = [
            "land-parcels" => LandParcel::class,
            "houses" => House::class,
            "apartments" => Apartment::class
        ];

        return $modelClasses[$applicables]::find($applicableId);
    }

    public function activate(Application $application) {
        $application->is_active = true;
        $application->save();

        return response()->noContent();
    }

    public function archive(Application $application) {
        $application->is_active = false;
        $application->save();

        return response()->noContent();
    }

    public function show(int $id) {
        $application = Application::with([
            "address",
            "user:id",
            "client",
            "applicable"
        ])->find($id);

        return response()->json($application);
    }
}
