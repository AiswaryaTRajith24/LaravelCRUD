<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserListingController extends Controller
{
    public function usersList(){
        $users = User::all();
        return response()->json($users);
    }
}
