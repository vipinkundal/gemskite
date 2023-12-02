<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function showAddUserPage()
    {
        return Inertia::render('Master/AddUser');
    }

    public function addUser(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => [
                    'msg' => 'User Added.',
                ],
            ]);
        }

        return response()->json([
            'error' => [
                'email' => 'Email already exists.',
            ],
        ], 409);
    }
}
