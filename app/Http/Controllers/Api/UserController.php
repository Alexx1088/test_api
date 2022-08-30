<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {

        return response()->json(User::get(), 200);

    }

    public function userById($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['error' => true, 'message' => 'user not found'],
                404);
        }
        return response()->json($user, 200);
    }

    public function userSave(Request $request)
    {

       /* try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()],
                401);
        }*/
        $rules = [
          'patronymic' => 'required|string|min:1|max:20',
            'name' => 'required|string|min:1|max:15',
            'surname' => 'required|string|min:1|max:20',
            'itn' => 'required|digits:12',
            'date_of_birth' => 'nullable',
            'images' => 'required|url',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'nullable',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($request->all());

        return response()->json($user, 201);

    }


}
