<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\User;

class PostController extends Controller
{
    public function getUsers()
    {
        $users = Products::all();
        return response()->json(['message' => $users]);
    }
}
