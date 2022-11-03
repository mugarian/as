<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        //
    }

    public function index()
    {
        $data = Product::all();
        if ($data) {
            return response()->json([
                'message' => 'All Data Product',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product Not Found',
                'data' => null
            ], 400);
        }
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            return response()->json([
                'message' => 'Product Found',
                'seller' => $product->seller->first_name .' '. $product->seller->last_name,
                'category' => $product->category->name,
                'data' => $product
            ], 200);
        } else {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request['seller_id'] = auth()->user()->id;
        $request['slug'] = Str::of($request['name'].'-'.rand())->slug();

        $validated = $this->validate($request, [
            'seller_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'slug' => 'required|unique:products,slug',
            'desc' => 'required',
            'artist' => 'nullable|max:255',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'price' => 'required|integer',
            'discount' => 'nullable|integer',
            'quantity' => 'required|integer',
            'image' => 'required|image|max:2048',
            'tags' => 'nullable|max:255',
        ]);

        $validated['name'] = ucwords($validated['name']);
        $validated['desc'] = ucfirst($validated['desc']);
        $validated['dimension'] = $validated['width'].'x'.$validated['height'];

        if ($request['artist']) {
            $validated['artist'] = ucwords($validated['artist']);
        }

        $validated['image'] = $request->file('image')->move('product-image', Str::random(32) .'.'. $request->file('image')->getClientOriginalExtension());

        $product = Product::create($validated);
        // $masuk = DB::table('products')->insert($validated);
        if ($product) {
            return response()->json([
                'message' => 'Product Succesfully created',
                'data' => $validated
            ], 201);
        } else {
            return response()->json([
                'message' => 'Product error',
                'data' => null
            ], 404);
        }
    }

    //
}
