<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function PHPUnit\Framework\isNull;

class ClientController extends Controller {

    public function store(StoreClientRequest $request) {
        $data = $request->safe();
        $client = Client::where(["phone_number" => $data->phone_number])->first();

        if ($client === null) {
            $client = Client::create($data->toArray());
            return response()->json($client->id, Response::HTTP_CREATED);
        }

        if ($client->name !== $data->name || $client->last_name !== $data->last_name) {
            return response()->json(
                ["errors" => ["phone_number" => "This phone number has already been taken by another client"]],
                Response::HTTP_CONFLICT
            );
        }

        return response()->json($client->id, Response::HTTP_OK);
    }
}
