<?php

namespace App\Repositories;


use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AuthRepository
{
    use ApiResponse;
    /**
     * @var User
     */
    protected $attendance;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(Model $model)
    {
        $this->model = $model;

    }

    /**
     * Method accepts an instance of `RegisterRequest` and returns
     * a JsonResponse responsible for registered user information 
     *
     * @param  $request - An instance of `RegisterRequest`
     *
     * @return  $user - An instance of `User` 
     */

    public function register($request)
    {
        $user = $this->model::create($request->all());
        return $user;
    }
    /**
     * Method accepts an instance of `LoginRequest` and returns
     * a JsonResponse responsible for logged in user with token.
     *
     * @param  $request - An instance of `LoginRequest`
     *
     * @return  $user - An instance of `User` 
     * @return  `Invalid data message` 
     */
    public function login($request)
    {
        if (Auth::attempt(['user_id' => $request->user_id, 'password' => $request->password])) {
            /* @var User $user */
            $user = $this->model::findOrFail(Auth::id());
            $user->token = $user->createToken('api-login')->plainTextToken;
            return $user;
        } else {

            return "The given data was invalid.";
        }
    }


}