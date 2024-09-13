<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;

class AuthService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = new AuthRepository($user);
    }
     /**
     * Register a new User.
     * 
     */
    public function register($request)
    {
        return $this->user->register($request);
    }
    /**
     * login the user and get a token via given credentials.
     *
     */
        public function login($request)
    {
        return $this->user->login($request);
    }
   

   
}