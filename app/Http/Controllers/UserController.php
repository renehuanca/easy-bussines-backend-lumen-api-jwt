<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use  App\User;
use Illuminate\Validation\ValidationException;


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
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return JsonResponse
     */
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }
    }

    /**
     * Update one user
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);
        $user = User::findOrFail($id);

        try {
            $user->update($request->all());

            return response()->json(['user' => $user, 'message' => 'UPDATED'], 200);
        } catch (Exception $e) {

            return response()->json(['message' => 'User update Failed!'], 409);
        }
    }

    /**
     * activate and inactivate one user in users.state
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function active($id)
    {

        $user = User::findOrFail($id);
        $is_active = $user->state;
        if ($is_active != 1) {
            $customer = User::where('id', $id)
                ->update(['state' => 1]);

            // activate user
            return response()->json(['customer' => $customer, 'message' => 'ACTIVATE USER'], 201);
        }

        // inactivate user
        try {
            $customer = User::where('id', $id)
                ->update(['state' => 0]);

            return response()->json(['customer' => $customer, 'message' => 'INACTIVATE USER'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'User activate or inactivate Failed!'], 409);
        }
    }

}
