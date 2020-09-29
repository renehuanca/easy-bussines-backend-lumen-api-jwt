<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;
use Exception;

class CategoryController extends Controller
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
     * Get all Categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Categorie::where('state', 1)
                                ->orderBy('created_at', 'DESC')
                                ->get();
        try {
            return response()->json(['categories' =>  $categories], 200);
        } catch ( Exception $error ) {
            return response()->json(['message' => 'Categories not found!'], 404);
        }
    }

    /**
     * Get one Categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $category = Categorie::where('id', $id)
                                ->where('state', 1)
                                ->get();
            return response()->json(['category' =>  $category], 200);
        } catch ( Exception $error ) {
            return response()->json(['message' => 'Category not found!'], 404);
        }
    }

    /**
     * Store Categorie.
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
        ]);

        try {
            $category = new Categorie();
            $category->name = $request->input('name');
            $category->last_user = $request->input('last_user');
            $category->state = $request->input('state');
            $category->save();

            return response()->json(['category' => $category, 'message' => 'CREATED'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Category Registration Failed!'], 409);
        }
    }

    /**
     * Update Categories.
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
        ]);
        $category = Categorie::findOrFail($id);
        try {
            $category->update($request->all());

            return response()->json(['category' => $category, 'message' => 'UPDATED'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Category Registration Failed!'], 409);
        }
    }

    /**
     * Delete Categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete($id, Request $request)
    {

        try {
            $category = Categorie::where('id', $id)
                                ->where('state', 1)
                                ->update(['last_user' => $request->last_user, 'state' => 0]);
            $category = Categorie::findOrFail($id);
            return response()->json(['category' => $category, 'message' => 'DELETED'], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'Category Elimination Failed!'], 409);
        }
    }
}
