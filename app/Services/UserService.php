<?php

namespace App\Services;

use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Log;

class UserService{

    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register($data)
    {
        return $this->userRepo->register($data);
    }

    public function login($data){
    
        $result = $this->userRepo->login($data);
        if ($result === "USER_NOT_EXISTS") {
            throw new BadRequestException(BadRequestException::NOT_FOUND, "There is no user account associated with this email");
        }
        if ($result === "INVALID_CREDENTIALS") {
            throw new BadRequestException(BadRequestException::INVALID_REQUEST, "Invalid credentials");
        }
        
        Log::info('User authenticated successfully', ['user_id' => $result->id]);
        return $result;
    }
}