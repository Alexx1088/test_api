<?php

namespace App\Http\Controllers;

use App\Models\CountryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class AuthController extends Controller
{

    /* public function __construct()
     {
         $this->middleware('auth:api', ['except' => ['login','register']]);
     }*/

    public function login(Request $request)
    {
        $login_email = $request->email;

        $users = User::all();

        foreach ($users as $user) {

            if ($user->status === 'active' && $user->email === $login_email) {

                $request->validate([
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                ]);
                $credentials = $request->only('email', 'password');

                $token = Auth::attempt($credentials);
                if (!$token) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Unauthorized',
                    ], 401);
                }

                $user = Auth::user();
                return response()->json([
                    'status' => 'success',
                    'user' => $user,
                    'authorisation' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ]);

            }
            if ($user->status === !'active' || $user->email === !$login_email) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User is unauthorized',
                ], 404);
            }
        }

    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'surname' => 'required|string|min:1',
            'patronymic' => 'required|string|min:1',

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function me()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        Auth::user();
        $rules = [
            'patronymic' => 'required|min:1|max:20',
            'name' => 'required|min:1|max:20',
            'surname' => 'required|min:3|max:20',
            'itn' => 'required|digits:12',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::find($id);

        if (is_null($user)) {

            return response()->json(['error' => true, 'message' => 'Not found'], 404);

        }
        $user->update($request->all());

        return response()->json($user, 200);
    }

}
