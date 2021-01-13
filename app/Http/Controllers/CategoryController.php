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

        try {
            $categories = Categorie::where('is_deleted', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json(['categories' =>  $categories], 200);
        } catch (Exception $error) {

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
                ->where('is_deleted', 0)
                ->firstOrFail();
                
            return response()->json(['category' =>  $category], 200);
        } catch (Exception $error) {

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
            $category->last_user = auth()->user()->id;
            $category->is_deleted = 0;
            $category->save();

            return response()->json(['category' => $category, 'message' => 'CREATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Category Registration Failed!', $e], 409);
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

        try {
            $category = Categorie::where('id', $id)
                ->where('is_deleted', 0)
                ->firstOrFail();

            $category->last_user = auth()->user()->id;
            $category->update($request->all());

            return response()->json(['category' => $category, 'message' => 'UPDATED'], 201);
        } catch (Exception $e) {

            return response()->json(['message' => 'Categorie Updated Failed!'], 409);
        }
    }

    /**
     * Delete Categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete($id)
    {
        try {
            $category = Categorie::findOrFail($id);
            $category->last_user = auth()->user()->id;
            $category->is_deleted = 1;
            $category->save();

            return response()->json(['category' => $category, 'message' => 'DELETED'], 200);
        } catch (Exception $e) {

            return response()->json(['message' => 'Categorie Elimination Failed!'], 409);
        }
    }
}
