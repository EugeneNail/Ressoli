<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Apartment;
use App\Models\Application;
use App\Models\Client;
use App\Models\House;
use App\Models\LandParcel;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ApplicationManagement {

    public function authorizeUserOrFail(Request $request, Application $application) {
        if ($request->user()->id !== $application->user_id) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }


    public function getApplicable(string $applicables, int | string $applicableId): Model {
        $modelClasses = [
            "land-parcels" => LandParcel::class,
            "houses" => House::class,
            "apartments" => Apartment::class
        ];

        return $modelClasses[$applicables]::find($applicableId);
    }


    public function setRelations(Application $application, Request $request) {
        $data = $request->safe();
        $applicables = $request->route()->parameter("applicables");
        $client = Client::find($data->client_id);
        $address = Address::find($data->address_id);
        $applicable = $this->getApplicable($applicables, $data->applicable_id);

        $application->client()->associate($client);
        $application->address()->associate($address);
        $application->applicable()->associate($applicable);
    }


    public function associatePhotos(array $photoIds, Application $application, int $maxPhotos) {
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
}
