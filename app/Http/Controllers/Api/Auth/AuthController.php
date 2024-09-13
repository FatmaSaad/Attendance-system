<?php

namespace App\Http\Controllers\Api\Auth;


use App\Traits\ApiResponse;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    use ApiResponse;
    protected $auth_service;
    public function __construct(AuthService $service)
    {
        $this->auth_service = $service;
    }
    /**
     * * Method accepts an instance of `RegisterRequest` and returns
     * a JsonResponse responsible for registered user information 
     *
     * @param RegisterRequest $request - An instance of `RegisterRequest`
     *
     * @return JsonResponse
     */

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->auth_service->register($request);
            return $this->successResponse($data);

        } catch (\Exception $e) {
            return $this->errorResponse(__('auth.Something went wrong'), 422);
        }
    }
    /**
     * * Method accepts an instance of `LoginRequest` and returns
     * a JsonResponse responsible for logged in user with token.
     *
     * @param LoginRequest $request - An instance of `LoginRequest`
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {

        try {
            $data = $this->auth_service->login($request);
            return $this->successResponse(new UserResource($data));
        } catch (\Exception $e) {
            return $this->errorResponse(__('auth.Unauthorised'), 401);
        }
    }


}
