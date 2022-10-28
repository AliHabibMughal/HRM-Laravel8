<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'message' => 'All Users Retrieved Successfully',
            'data' => $users,
        ]);
    }

    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function register(Request $request)
    {
        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => [
                        'required',
                        Password::min(8)->mixedCase()->numbers(),
                    ],
                    'DOB' => 'required|date',
                    'address' => 'required',
                    'phone' => 'required|digits:11',
                    'designation' => 'required',
                    'roles' => 'required',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'DOB' => $request->DOB,
                'address' => $request->address,
                'phone' => $request->phone,
                'designation' => $request->designation,

            ])->assignRole($request->roles);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!($user)) {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found',
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'User retrieved successfully',
            'data' => $user,
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found',
            ]);
        }
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => [
                    'required',
                    Password::min(8)->mixedCase()->numbers(),
                ],
                'DOB' => 'required|date',
                'address' => 'required',
                'phone' => 'required|digits:11',
                'designation' => 'required',
                'roles' => 'required',
            ],
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validate->errors()
            ], 401);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->DOB = $request->DOB;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->designation = $request->designation;
        $user->assignRole($request->roles);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User Updated Successfully',
            'data' => $user,
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User Not Found',
            ]);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User Deleted Successfully',
            'data' => $user,
        ]);
    }
}
