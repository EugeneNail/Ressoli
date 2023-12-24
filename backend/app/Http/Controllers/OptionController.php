<?php

namespace App\Http\Controllers;

use App\Actions\GetOptions;
use App\Http\Requests\IndexApplicableOptionsRequest;
use App\Models\Address;
use App\Models\Apartment;
use App\Models\Application;
use App\Models\House;
use App\Models\LandParcel;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OptionController extends Controller {

    public function __invoke(Request $request, GetOptions $getOptions, string $type) {
        $map = [
            "land-parcels" => LandParcel::class,
            "houses" => House::class,
            "apartments" => Apartment::class,
            "addresses" => Address::class,
            "applications" => Application::class
        ];

        if (!array_key_exists($type, $map)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $options = $getOptions->run($map[$type]);

        return response()->json($options, Response::HTTP_OK);
    }
}
