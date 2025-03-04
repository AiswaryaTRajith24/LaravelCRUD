<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UpdateUserController extends Controller
{
    public function updateUser(Request $request, $id){
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        // Validate request data
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'phone_number' => 'sometimes|regex:/^(\+?[0-9]{1,3})?[0-9]{10}$/',
            'address' => 'sometimes|string|max:500',
            'role' => 'sometimes|in:admin,user',
        ]);
    
        // Update user details
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->has('address')) {
            $user->address = $request->address;
        }
        if ($request->has('role')) {
            $user->role = $request->role;
        }
    
        $user->save();
    
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
}
