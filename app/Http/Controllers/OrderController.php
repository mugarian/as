<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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

    public function pesan(Request $request) {
        $validated = $this->validate($request, [
            'buyer_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'order_number' => 'required|alpha_dash',
            'delivery_date' => 'required|date_format:d/m/Y',
            'phone_number' => 'required|numeric|unique:users,phone_number|min:8|max:15',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'zipcode' => 'required|numeric|max:5',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:buyer,seller,admin'
        ]);

        $masuk = DB::table('users')->insert($validated);
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
