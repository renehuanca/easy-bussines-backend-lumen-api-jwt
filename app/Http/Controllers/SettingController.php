<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Exception;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get one Customers.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $setting = Setting::where('id', 1)
                ->where('is_deleted', 0)
                ->firstOrFail();
                
            return response()->json(['setting' =>  $setting], 200);
        } catch (Exception $error) {

            return response()->json(['message' => 'Setting not found!'], 404);
        }
    }

    
    /**
     * Update Customers.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        try {
            $setting = Setting::where('id', $id)
                        ->where('is_deleted', 0)
                        ->firstOrFail();

            $setting->last_user = auth()->user()->id;
            $setting->update($request->all());

            return response()->json(['setting' => $setting, 'message' => 'UPDATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Setting Updated Failed!'], 409);
        }
    }
}
