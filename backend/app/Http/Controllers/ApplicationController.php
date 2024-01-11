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
            "applicable",
            "photos"
        ])->find($id);

        return response()->json($application);
    }


    public function index(IndexApplicationsRequest $request) {
        $types = $request->input("types");
        $owned = $request->boolean("owned");
        $status = $request->input("status");
        $startPrice = $request->has("start-price");
        $endPrice = $request->has("end-price");
        $startArea = $request->has("start-area");
        $endArea = $request->has("end-area");
        $contract = $request->input("contract");
        $startDate = $request->input("start-date");
        $endDate = $request->input("end-date");
        $noPhotos = $request->boolean("no-photos");

        $applications = Application::query()
            ->with(["client", "address", "applicable", "photos"])
            ->when($types,      fn ($query) => $this->applyTypeFilters($query, $types))
            ->when($owned,      fn ($query) => $query->where("user_id", $request->user()->id))
            ->when($status,     fn ($query) => $query->where("is_active", ["Active" => true, "Archived" => false][$status]))
            ->when($startPrice, fn ($query) => $query->where("price", ">=", $request->input("start-price")))
            ->when($endPrice,   fn ($query) => $query->where("price", "<=", $request->input("end-price")))
            ->when($startArea,  fn ($query) => $query->whereRelation("applicable", "area", ">=", $request->input("start-area")))
            ->when($endArea,    fn ($query) => $query->whereRelation("applicable", "area", "<=", $request->input("end-area")))
            ->when($contract,   fn ($query) => $query->where("contract", $contract))
            ->when($startDate,  fn ($query) => $query->where("created_at", ">=", $startDate . " 00:00:00"))
            ->when($endDate,    fn ($query) => $query->where("created_at", "<=", $endDate . " 00:00:00"))
            ->when($noPhotos,   fn ($query) => $query->doesntHave("photos"))
            ->paginate(25);

        return CardApplicationResource::collection($applications);
    }

    private function applyTypeFilters(Builder $query, array $types): Builder {
        $map = [
            "land-parcels" => LandParcel::class,
            "houses" => House::class,
            "apartments" => Apartment::class
        ];
        $modelClasses = collect($types)->map(fn ($type) => $map[$type]);

        return $query->whereIn("applicable_type", $modelClasses);
    }

    private function applyStatusFilters(Builder $query, string $status): Builder {
        $map = [
            "active" => true,
            "archived" => false
        ];

        return $query->where("is_active", $map[$status]);
    }
}
