<?php

namespace App\Http\Controllers\Api\Country;

use App\Http\Controllers\Api\Controller;
use App\Models\CountryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class CountryController extends Controller
{
    public function country()
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()],
                401);
        }
            return response()->json(CountryModel::get(), 200);

        }


    public function countryById($id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()],
                401);
        }
        $country = CountryModel::find($id);

        if (is_null($country)) {

            return response()->json(['error' => true, 'message' => 'Not found'], 404);

        }

        return response()->json($country, 200);

    }

    public function countrySave(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()],
                401);
        }
        $rules = [
            'alias' => 'required|min:2|max:2',
            'name' => 'required|min:3',
            'name_en' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $country = CountryModel::create($request->all());

        return response()->json($country, 201);

    }

    public function countryEdit(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()],
                401);
        }
        $rules = [
            'alias' => 'required|min:2|max:2',
            'name' => 'required|min:3',
            'name_en' => 'required|min:3',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $country = CountryModel::find($id);

        if (is_null($country)) {

            return response()->json(['error' => true, 'message' => 'Not found'], 404);

        }
        $country->update($request->all());

        return response()->json($country, 200);

    }

    public function countryDelete(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        } catch (UserNotDefinedException $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()],
                401);
        }
        $country = CountryModel::find($id);

        if (is_null($country)) {

            return response()->json(['error' => true, 'message' => 'Not found'], 404);

        }
        $country->delete();

        return response()->json('', 204);

    }
}