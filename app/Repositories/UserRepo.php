<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserRepo{
    public function register($data){

        // Create a new user record in the database
        $user = User::create([
            'name' => $data['name'],
            'contact'=>$data['contact'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']), // Hash the password for security
        ]);

        // Return the created user object
        return $user;

    }

    public function login($data)
    {
        // Attempt to retrieve a user record by email
        $user = User::where('email', $data['email'])->first();
    
        // Check if a user with the given email exists
        if (!$user) {
            Log::info('not a user');
            return "USER_NOT_EXISTS";
        }
    

        if (Hash::check($data['password'], $user->password)) {
            // Return the user object if the password is correct
            Log::info($user);
            return $user;
        }
    
        // Return a message indicating the credentials are invalid
        return "INVALID_CREDENTIALS";
        Log::info('not ');
    }
    
}