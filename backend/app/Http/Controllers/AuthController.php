<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\AuthManagement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\MessageBag;

class AuthController extends Controller {

    public function store(StoreUserRequest $request, AuthManagement $management) {
        $data = $request->validated();

        if ($management->findUser($request) !== null) {
            return $management->getConflictResponse();
        }
        $user = User::create($data);

        return response()
            ->json($user->id, Response::HTTP_OK)
            ->withCookie($management->getAuthCookie($request, $user));
    }


    public function login(LoginRequest $request, AuthManagement $management) {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return $management->getUnauthorizedResponse();
        }
        $user = $management->findUser($request);

        return response()
            ->json($user->id, Response::HTTP_OK)
            ->withCookie($management->getAuthCookie($request, $user));
    }


    public function logout(Request $request) {
        $request->user()
            ->tokens()
            ->where(["name" => $request->ip()])
            ->delete();
        $cookie = Cookie::forget("access_token");

        return response()->noContent()->withCookie($cookie);
    }
}
