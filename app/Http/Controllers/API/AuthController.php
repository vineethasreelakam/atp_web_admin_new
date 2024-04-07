<?php

namespace App\Http\Controllers\API;

use App\Models\Api\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Models\Api\RoleMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);

            if (!$token) {
                return response()->json([
                    'message' => 'Unauthorized',
                ], 401);
            }

            $user = Auth::user();

            $role_title = '';
            if($user->role_id) {
                $role = RoleMaster::where('id', $user->role_id)->first();
                if($role) {
                    $role_title = $role->title;
                }
            }

            $user->role_title = $role_title;
            
            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        try {
            return Auth::logout();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }

    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }


    //direct Password Reset
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $user = Auth::user();
            $old_password = $request->password_old;

            if (Auth::attempt(['email' => $user->email, 'password' => $old_password])) {
                $new_password = Hash::make($request->password_new);
                $user_update = DB::table('users')->where('id', $user->id)->update(['password' => $new_password]);
                if ($user_update) {

                    
                    $credentials = ['email' => $user->email, 'password' => $request->password_new];
                    $token = Auth::attempt($credentials);
        
                    if (!$token) {
                        return response()->json([
                            'message' => 'Unauthorized',
                        ], 401);
                    }
        
                    $user = Auth::user();
                    return response()->json([
                        'status' => 200,
                        'message' => "Password changed successfully.",
                        'user' => $user,
                        'authorization' => [
                            'token' => $token,
                            'type' => 'bearer',
                        ]
                    ]);


                    
                } else {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Something went wrong.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Wrong old password'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!!!',
                'exception' => $th->getMessage(),
                'code' => $th->getCode(),
            ]);
        }
    }



}