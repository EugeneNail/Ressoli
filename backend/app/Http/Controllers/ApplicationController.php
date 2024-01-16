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

    public function store(StoreApplicationRequest $request, ApplicationManagement $management) {
        $data = $request->validated();
        $application = new Application($data);
        $application->user()->associate($request->user());
        $management->setRelations($application, $request);
        $application->save();

        if ($request->has("photos")) {
            $management->associatePhotos($data["photos"], $application, $this->maxPhotos);
        }

        return response()->json($application->id, Response::HTTP_CREATED);
    }


    public function update(UpdateApplicationRequest $request, ApplicationManagement $management, string $applicables, Application $application) {
        if ($application === null) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $management->authorizeUserOrFail($request, $application);

        $data = $request->safe();
        $management->setRelations($application, $request);
        $application->update($data->toArray());
        $application->save();

        if ($request->has("photos")) {
            $application->photos()
                ->whereNotIn("id", $request->input("photos"))
                ->delete();
            $management->associatePhotos($data->photos, $application, $this->maxPhotos);
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    public function activate(Application $application, Request $request, ApplicationManagement $management) {
        $management->authorizeUserOrFail($request, $application);

        $application->is_active = true;
        $application->save();

        return response()->noContent();
    }


    public function archive(Application $application, Request $request, ApplicationManagement $management) {
        $management->authorizeUserOrFail($request, $application);

        $application->is_active = false;
        $application->save();

        return response()->noContent();
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
