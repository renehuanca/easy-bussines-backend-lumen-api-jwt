<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Exception;

class CustomerController extends Controller
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
     * Get all Customers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        try {
            $customers = Customer::where('is_deleted', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json(['customers' =>  $customers], 200);
        } catch (Exception $error) {

            return response()->json(['message' => 'Customers not found!'], 404);
        }
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
            $customer = Customer::where('id', $id)
                ->where('is_deleted', 0)
                ->firstOrFail();
                
            return response()->json(['customer' =>  $customer], 200);
        } catch (Exception $error) {

            return response()->json(['message' => 'Customer not found!'], 404);
        }
    }

    /**
     * Store Customer.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        try {
            $customer = new Customer();
            $customer->name = $request->input('name');
            $customer->email = $request->input('email');
            $customer->phone = $request->input('phone');
            $customer->company = $request->input('company');
            $customer->country = $request->input('country');
            $customer->city = $request->input('city');
            $customer->website = $request->input('website');
            $customer->social = $request->input('social');
            $customer->history = $request->input('history');
            $customer->last_user = auth()->user()->id;
            $customer->is_deleted = 0;
            $customer->save();

            return response()->json(['customer' => $customer, 'message' => 'CREATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Customer Registration Failed!', $e], 409);
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
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        try {
            $customer = Customer::where('id', $id)
                ->where('is_deleted', 0)
                ->firstOrFail();

            $customer->last_user = auth()->user()->id;
            $customer->update($request->all());

            return response()->json(['customer' => $customer, 'message' => 'UPDATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Customer Updated Failed!'], 409);
        }
    }

    /**
     * Delete Customers.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->last_user = auth()->user()->id;
            $customer->is_deleted = 1;
            $customer->save();

            return response()->json(['customer' => $customer, 'message' => 'DELETED'], 200);
        } catch (Exception $e) {

            return response()->json(['message' => 'Customer Elimination Failed!'], 409);
        }
    }
}
