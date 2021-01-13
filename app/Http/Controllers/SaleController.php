<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Sale;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
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
     * Get all Sales.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $sales = DB::table('Sales')
                ->join('products', 'products.id', '=', 'Sales.product_id')
                ->join('customers', 'customers.id', '=', 'Sales.customer_id')
                ->select('sales.*', 'products.name as product_name', 'products.unit_price', 'customers.name as customer_name')
                ->where('Sales.is_deleted', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json(['sales' =>  $sales], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'Sales not found!', $error], 404);
        }
    }

    /**
     * Get one Sales.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {


            $Sale = DB::table('Sales')
                ->join('products', 'products.id', '=', 'Sales.product_id')
                ->join('customers', 'customers.id', '=', 'Sales.customer_id')
                ->select('sales.*', 'products.name as product_name', 'products.unit_price', 'customers.name as customer_name')
                ->where('Sales.is_deleted', 0)
                ->where('Sales.id', $id)
                ->first();

            return response()->json(['sale' =>  $Sale], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'Sale not found!'], 404);
        }
    }

    /**
     * Store Sale.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'quantity' => 'integer',
            'total' => 'required',
        ]);

        try {
            $Sale = new Sale();
            $Sale->quantity = $request->input('quantity');
            $Sale->total = $request->input('total');
            $Sale->product_id = $request->input('product_id');
            $Sale->customer_id = $request->input('customer_id');
            $Sale->last_user = auth()->user()->id;
            $Sale->is_deleted = 0;
            $Sale->save();

            return response()->json(['sale' => $Sale, 'message' => 'CREATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Sale Registration Failed!', $e], 409);
        }
    }


    /**
     * Delete Sales.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $Sale = Sale::findOrFail($id);
            $Sale->last_user = auth()->user()->id;
            $Sale->is_deleted = 1;
            $Sale->save();

            return response()->json(['Sale' => $Sale, 'message' => 'DELETED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Sale Elimination Failed!'], 409);
        }
    }
}
