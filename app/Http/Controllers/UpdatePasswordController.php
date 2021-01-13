<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Validation\ValidationException;

class UpdatePasswordController extends Controller
{
    /**
     * Create a new UpdatePasswordController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Update the password for the user.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        // Validate the new password length...
        $this->validate($request, [
            'newPassword' => 'required|confirmed',
        ]);

        try {
            $user = User::find( auth()->user()->id );

            $user->fill([
                'password' => Hash::make($request->newPassword)
            ])->save();

            return response()->json(['message' => 'UPDATED'], 200);
        } catch (Exception $e) {

            return response()->json(['message' => 'Password Registration Failed!', $e], 409);
        }
    }
}
