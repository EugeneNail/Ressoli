<?php

namespace App\Http\Controllers;

use App\Actions\GetOptions;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OptionController extends Controller {

    public function forAddress(GetOptions $getOptions) {
        $options = $getOptions->run(Address::class);

        return new JsonResponse($options, Response::HTTP_OK);
    }
}
