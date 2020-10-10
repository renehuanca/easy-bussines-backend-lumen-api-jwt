<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use  App\User;


class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function showAllUsers()
    {
        return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function showOneUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }
    }

    /**
     * Update one user
     * 
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id) 
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmed' => 'required',
        ]);
        $user = User::findOrFail($id);
        try {
        
            $request->password =  Hash::make($request->password);

            $user->update($request->all());
            //return successful response
            return response()->json(['user' => $user, 'message' => 'UPDATED'], 200);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User update Failed!'], 409);
        }
    }
}
