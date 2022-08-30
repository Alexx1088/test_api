<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return response()->json(['error' => true, 'message' => 'admin_panel'],
            200);
    }
}
