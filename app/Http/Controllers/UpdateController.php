<?php

namespace App\Http\Controllers;

use App\Models\CountryModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class UpdateController extends Controller
{
    public function user_update(Request $request, $id)
    {
     //   dd(111);
      /*  try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()],
                401);
        }*/
        $rules = [
         //   'alias' => 'required|min:2|max:2',
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
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
