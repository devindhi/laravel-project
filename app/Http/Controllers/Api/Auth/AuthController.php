<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterationRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    private $userService;


    public function __construct(UserService  $userService)
    {
        $this->userService = $userService;
    }

    function loginview()
    {
        return view('login');
    }

    function registerview()
    {
        return view('registration');
    }

    function home()
    {
        Log::info('home');
        return view('home');
    }


    public function register(RegisterationRequest $request)
    {
        Log::info('register method called in controller');
        $data = [
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'contact' =>  $request->getContact(),
            'password' => $request->getPassword(),
        ];

        $user = $this->userService->register($data);
        return redirect('/login');
    }


    public function login(LoginRequest $request)
    {
        Log::info('Login method called in controller');

        $data = [
            "email" => $request->getEmail(),
            "password" => $request->getPassword()
        ];

        Log::info('Login request data:', $data);

        $user = $this->userService->login($data);

        if ($user) {
            Log::info('User authenticated successfully', ['user_id' => $user->id]);

            // Generate JWT token
            $token = auth()->login($user);
            Log::info('JWT token generated', ['token' => $token]);

            // Store the token in a cookie
            Cookie::queue(Cookie::make('jwt_token', $token, 60 * 24)); // 1 day expiration, adjust as needed

            session(['user_name' => $user->name]);
            session(['user_id' => $user->id]);
            // Store the token in a cookie (HTTP only for security)

            return response()->json([
                'token' => $token,
                'message' => 'User authenticated successfully'
            ])->header('Authorization', 'Bearer ' . $token);
        } else {
            Log::warning('User authentication failed', $data);


            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid credentials'
            ], 401); // Use 401 Unauthorized for failed authentication
        }
    }
    public function logout(Request $request)
    {
      Log::info("came to logout");
        $cookie = Cookie::forget('jwt_token');
        return redirect('/')->withCookie($cookie);
        // Return a JSON response for successful logout
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ]);

        
    }







    public function responseWithToken($token, $user)
    {

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'type' => 'bearer'
        ]);
    }
}
