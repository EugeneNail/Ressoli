<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Cookie;

class AuthManagement {

    public function getAuthCookie(Request $request, User $user): Cookie {
        $token = $user->createToken($request->ip())->plainTextToken;

        return cookie('access_token', $token, 60 * 24 * 7);
    }


    public function findUser(Request $request): User|null {
        return User::where("email", $request->input("email"))->first();
    }


    public function getUnauthorizedResponse(): JsonResponse {
        $messages = new MessageBag();
        $error = "You have entered an invalid email or password";
        $messages->add("email", $error);
        $messages->add("password", $error);

        return response()->json(["errors" => $messages], Response::HTTP_UNAUTHORIZED);
    }


    public function getConflictResponse(): JsonResponse {
        $messages = new MessageBag();
        $messages->add("email", "The email has already been taken by another user.");
        return response()->json(["errors" => $messages], Response::HTTP_CONFLICT);
    }
}
