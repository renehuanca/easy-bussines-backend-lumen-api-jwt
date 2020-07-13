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
        $customers = Customer::where('state', 1)
                                ->orderBy('created_at', 'DESC')
                                ->get();
        try {
            return response()->json(['customers' =>  $customers], 200);
        } catch ( Exception $error ) {
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
                                ->where('state', 1)
                                ->get();
            return response()->json(['customer' =>  $customer], 200);
        } catch ( Exception $error ) {
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
            'email' => 'required|email|unique:customers',
            'company' => 'string',
            'country' => 'string',
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
            $customer->last_user = $request->input('last_user');
            $customer->state = $request->input('state');
            $customer->save();

            return response()->json(['customer' => $customer, 'message' => 'CREATED'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Customer Registration Failed!'], 409);
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
            'company' => 'string',
            'country' => 'string',
        ]);
        $customer = Customer::findOrFail($id);
        try {
            $customer->update($request->all());

            return response()->json(['customer' => $customer, 'message' => 'UPDATED'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Customer Registration Failed!'], 409);
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
            $customer = Customer::where('id', $id)
                                ->where('state', 1)
                                ->update(['state' => 0]);

            return response()->json(['customer' => $customer, 'message' => 'DELETED'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Customer Elimination Failed!'], 409);
        }
    }
}
