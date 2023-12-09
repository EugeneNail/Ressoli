<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller {
    public function store(StoreUserRequest $request) {
        $data = $request->validated();
        $user = User::create($data);
        $token = $user->createToken($request->ip())->plainTextToken;
        return new JsonResponse($token, Response::HTTP_CREATED);
    }
}
