<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class ConvertKeysCase {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $request->replace($this->convertToCase("snake", $request->input()));

        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = json_decode($response->content(), true);
            $response->setData($this->convertToCase("camel", $data));
        }

        return $response;
    }

    public function convertToCase(string $case, mixed $data): mixed {
        if ($case !== "snake" && $case !== "camel") {
            throw new \InvalidArgumentException;
        }

        if (!is_array($data)) {
            return $data;
        }

        $new = [];

        foreach ($data as $key => $value) {
            $new[Str::{$case}($key)] = is_array($data[$key]) ? $this->convertToCase($case, $data[$key]) : $value;
        }

        return $new;
    }
}
