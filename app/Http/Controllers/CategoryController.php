<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $category = Category::all();
        if ($category) {
            return response()->json([
                'message' => 'Data Category',
                'data' => $category
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category Not Found',
                'data' => NULL
            ], 400);
        }
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            return response()->json([
                'message' => 'Category has been found',
                'data' => $category
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category not found',
                'data' => $category
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request['slug'] = Str::of($request['name'] . '-' . rand())->slug();

        $validated  = $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug'
        ]);


        $category = Category::create($validated);
        // $masuk = DB::table('categories')->insert($validated);
        if ($category) {
            return response()->json([
                'message' => 'Category success to create',
                'data' => $category
            ], 201);
        } else {
            return response()->json([
                'message' => 'Category failed to create',
                'data' => NULL
            ], 404);
        }
    }

    public function update(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $request['slug'] = Str::of($request['name'].'-'.rand())->slug();
        $validated = $this->validate($request, [
            'name' => 'required'
        ]);


        $update = $category->update($validated);

        if ($update) {
            return response()->json([
                'message' => 'Category success to update',
                'data' => $validated
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category fail to update',
                'data' => NULL
            ], 400);

        }
    }

    public function delete($slug) {
        $category = Category::where('slug', $slug)->first();
        $delete = Category::destroy($category->id);
        if ($delete) {
            return response()->json([
                'message' => 'Category has been deleted'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category failed to delete'
            ], 400);

        }
    }
}
