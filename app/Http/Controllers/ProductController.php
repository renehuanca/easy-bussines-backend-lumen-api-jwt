<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Product;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
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
     * Get all Products.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $products = DB::table('categories')
                ->join('products', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.id as category_id', 'categories.name as category_name')
                ->where('products.is_deleted', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json(['products' =>  $products], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'Products not found!', $error], 404);
        }
    }

    /**
     * Get one Products.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $product = DB::table('categories')
                ->join('products', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.id as category_id','categories.name as category_name')
                ->where('products.is_deleted', 0)
                ->where('products.id', $id)
                ->first();

            return response()->json(['product' =>  $product], 200);
        } catch ( Exception $error ) {

            return response()->json(['message' => 'Product not found!'], 404);
        }
    }

    /**
     * Store Product.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'unit_price' => 'required',
            'total_in_stock' => 'required',
        ]);

        try {
            $Product = new Product();
            $Product->name = $request->input('name');
            $Product->quantity = $request->input('quantity');
            $Product->unit_price = $request->input('unit_price');
            $Product->total_in_stock = $request->input('total_in_stock');
            $Product->category_id = $request->input('category_id');
            $Product->last_user = auth()->user()->id;
            $Product->is_deleted = 0;
            $Product->save();

            return response()->json(['product' => $Product, 'message' => 'CREATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Product Registration Failed!', $e], 409);
        }
    }

    /**
     * Update Products.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update($id, Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'unit_price' => 'required',
            'total_in_stock' => 'required',
        ]);

        try {
            $Product = Product::findOrFail($id);
            $Product->last_user = auth()->user()->id;
            $Product->update($request->all());

            return response()->json(['product' => $Product, 'message' => 'UPDATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Product Registration Failed!'], 409);
        }
    }

    /**
     * Delete Products.
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->last_user = auth()->user()->id;
            $product->is_deleted = 1;
            $product->save();

            return response()->json(['product' => $product, 'message' => 'DELETED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Product Elimination Failed!'], 409);
        }
    }
}
