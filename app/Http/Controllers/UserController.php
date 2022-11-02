<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class UserController extends Controller
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

    public function register(Request $request)
    {
        $validated = $this->validate($request, [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone_number' => 'required|numeric|unique:users,phone_number',
            'address' => 'required',
            'username' => 'required|regex:/^[A-Za-z0-9_]+$/|max:15|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:buyer,seller,admin',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['first_name'] = ucwords($validated['first_name']);
        $validated['last_name'] = ucwords($validated['last_name']);
        $validated['address'] = ucfirst($validated['address']);
        $validated['password'] = Hash::make($validated['password']);
        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->move('user-image', Str::random(32) . '.' . $request->file('image')->getClientOriginalExtension());
        }

        $masuk = User::create($validated);
        if ($masuk) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil',
                'data' => $masuk
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal',
            ], 405);
        }
    }

    public function login(Request $request)
    {
        $validated = $this->validate($request, [
            'useremail' => 'required',
            'password' => 'required'
        ]);

        $user = DB::table('users')->where('username', $validated['useremail'])->orWhere('email', $validated['useremail'])->first();

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'data' => 'Username atau Password Salah'
            ], 400);
        }

        $time = time();

        $payload = [
            'iat' => $time,
            'exp' => $time + (60 * 60 * 24), // expire for a day
            'uid' => $user->id
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json([
            'token' => $token,
            'data' => $user
        ], 200);
    }

    public function show()
    {
        $user = User::find(auth()->user()->id);
        if ($user) {
            return response()->json([
                'message' => 'User Found',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);

        // $validated = $this->validate($request, [
        //     'first_name' => 'required|max:50',
        //     'last_name' => 'required|max:50',
        //     'address' => 'required',
        //     'password' => 'required',
        //     'image' => 'nullable|image|max:2048'
        // ]);

        $rules = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'address' => 'required',
            'password' => 'required',
            'image' => 'nullable|image|max:2048'
        ];


        if ($request['username'] != $user->username) {
            // $validated['username'] = 'required|regex:/^[A-Za-z0-9_]+$/|max:15|unique:users,username';
            $rules['username'] = 'required|regex:/^[A-Za-z0-9_]+$/|max:15|unique:users,username';
        }


        if ($request['email'] != $user->email) {
            // $validated['email'] = 'required|email|unique:users,email';
            $rules['email'] = 'required|email|unique:users,email';
        }

        if ($request['phone_number'] != $user->phone_number) {
            // $validated['phone_number'] = 'required|numeric|unique:users,phone_number';
            $rules['phone_number'] = 'required|numeric|unique:users,phone_number';
        }

        $validated = $this->validate($request, $rules);

        if ($request->file('image')) {
            unlink($user->image);
            $validated['image'] = $request->file('image')->move('user-image', Str::random(32) . '.' . $request->file('image')->getClientOriginalExtension());
        }

        $validated['password'] = Hash::make($validated['password']);

        $update = User::find($user->id)->update($validated);

        if ($update) {

            return response()->json([
                'message' => 'Profile has been updated',
                'data' => $validated
            ], 200);
        } else {
            return response()->json([
                'message' => 'Update Profile is Error',
                'data' => null
            ], 400);
        }
    }

    public function delete()
    {
        $user = User::find(auth()->user()->id);
        if ($user->image) {
            unlink($user->image);
        }
        $delete = User::destroy($user->id);
        if ($delete) {
            return response()->json([
                'message' => 'Profile has been deleted'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Profile cancel deleted'
            ], 400);
        }
    }
}
