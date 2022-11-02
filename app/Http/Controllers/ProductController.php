<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

    public function index() {
        $data = Product::all();
        return response()->json($data, 200);
    }

    public function show($slug) {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            return response()->json($product, 200);
        } else {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
    }

    public function store(Request $request) {
        $validated = $this->validate($request, [
            'seller_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'desc' => 'required',
            'artist' => 'required|max:255',
            'size_p' => 'required',
            'size_l' => 'required',
            'price' => 'required',
            'discount' => 'nullable',
            'quantity' => 'required',
            'image' => 'required|file|mimetypes:image/jpeg,image/png|max:2048',
            'tags' => 'nullable|max:255',
        ]);

        $validated['image'] = $request->file('image')->move('gambar', $request->file('image')->getClientOriginalName());

        $masuk = DB::table('products')->insert($validated);
        if ($masuk) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil',
                'data' => $validated
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal',
            ], 201);

        }
    }

    //
}
