<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class AuthController extends Controller {

    public function store(StoreUserRequest $request) {
        $data = $request->validated();
        $user = User::where("email", $data["email"])->first();

        if ($user !== null) {
            $messages = new MessageBag();
            $messages->add("email", "The email has already been taken by another user.");
            return response()->json(["errors" => $messages], Response::HTTP_CONFLICT);
        }

        $user = User::create($data);
        $token = $user->createToken($request->ip())->plainTextToken;

        return response()->json($token, Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request, MessageBag $messages) {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            $error = "You have entered an invalid email or password";
            $messages->add("email", $error);
            $messages->add("password", $error);

            return response()->json(["errors" => $messages], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where(["email" => $data["email"]])->first();
        $token = $user->createToken($request->ip())->plainTextToken;

        return response()->json($token, Response::HTTP_OK);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->where(["name" => $request->ip()])->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
