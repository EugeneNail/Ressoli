<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexApplicationsRequest;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Resources\CardApplicationResource;
use App\Models\Address;
use App\Models\Apartment;
use App\Models\Application;
use App\Models\Client;
use App\Models\House;
use App\Models\LandParcel;
use App\Models\Photo;
use App\Models\User;
use App\Services\ApplicationFilter;
use App\Services\ApplicationManagement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller {

    private int $maxPhotos = 15;

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

        if ($request->has("photos")) {
            $this->associatePhotos($data->photos, $application, $this->maxPhotos);
        }


        return response()->json($application->id, Response::HTTP_CREATED);
    }


    public function update(UpdateApplicationRequest $request, string $applicables, Application $application) {

        if ($application === null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $this->authorizeUser($request, $application);

        $data = $request->safe();
        $client = Client::find($data->client_id);
        $address = Address::find($data->address_id);
        $applicable = $this->getApplicable($applicables, $data->applicable_id);

        $application->client()->associate($client);
        $application->address()->associate($address);
        $application->applicable()->associate($applicable);
        $application->update($data->toArray());
        $application->save();

        if ($request->has("photos")) {
            $application->photos()
                ->whereNotIn("id", $request->input("photos"))
                ->delete();
            $this->associatePhotos($data->photos, $application, $this->maxPhotos);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    private function associatePhotos(array $photoIds, Application $application, int $maxPhotos) {
        Photo::findMany($photoIds)
            ->take($maxPhotos)
            ->each(function ($photo) use ($application) {
                $oldPath = $photo->path;
                $newPath = str_replace("/temp", "", $photo->path);
                $photo->setAttribute("path", $newPath)
                    ->application()
                    ->associate($application)
                    ->save();
                Storage::disk("local")->move($oldPath, $newPath);
            });
    }


    private function getApplicable(string $applicables, int | string $applicableId): Model {
        $modelClasses = [
            "land-parcels" => LandParcel::class,
            "houses" => House::class,
            "apartments" => Apartment::class
        ];

        return $modelClasses[$applicables]::find($applicableId);
    }


    public function activate(Application $application, Request $request) {
        $this->authorizeUser($request, $application);

        if ($application->user_id !== $request->user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $application->is_active = true;
        $application->save();

        return response()->noContent();
    }


    public function archive(Application $application, Request $request) {
        $this->authorizeUser($request, $application);

        if ($application->user_id !== $request->user()->id) {
            abort(Response::HTTP_FORBIDDEN);
        }
        $application->is_active = false;
        $application->save();

        return response()->noContent();
    }

    private function authorizeUser(Request $request, Application $application) {
        if ($request->user()->id !== $application->user_id) {
            abort(403);
        }
    }

    public function show(int $id) {
        $application = Application::with([
            "address",
            "user:id",
            "client",
            "applicable",
            "photos"
        ])->find($id);

        return response()->json($application);
    }


    public function index(IndexApplicationsRequest $request) {
        $applications = (new ApplicationFilter($request))
            ->byTypes()
            ->byStatus()
            ->byAreaRange()
            ->byDateRange()
            ->byPriceRange()
            ->byContract()
            ->byOwned()
            ->query()
            ->paginate(25);

        return CardApplicationResource::collection($applications);
    }
}
