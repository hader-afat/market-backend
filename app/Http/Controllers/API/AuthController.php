<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'region' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'image' => 'required|file',
        ]);
        if($data['region'] == 'cairo')
        {
            // dd($request['region']);
            $user = new User;
            $user->setConnection('mysql');
            /****************image************************/
            if( $request->hasFile('image') )
            {
                $validator_2 = $request->validate([
                    'image' => 'mimes:jpeg,bmp,png,jpg' // Only allow .jpg, .bmp and .png file types.
                ]);
                //save image in folder
                $file_extention = $request->image->getClientOriginalExtension();
                $file_name = time(). '.' .$file_extention;
                $file_path = 'images/users' ;  //get image path
                $request->image->move($file_path,$file_name);
            }
            $x = $user->create([
                'name' => $data['name'],
                'image' => $file_name,
                'username' => $data['username'],
                'region' => $data['region'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            // $token = $user->createToken($request->token_name);
            // $token = $x->createToken('marketProjectToken')->plainTextToken; //correct
            $response =[
                'message' => 'Sign Up successfully',
                'user' => $x,
                // 'token' => $token
            ];
            return response($response, 201);
            
        }
        else if($data['region'] == 'giza')
        {
            $user = new User;
            $user->setConnection('mysql_2');
            /****************image************************/
            if( $request->hasFile('image') )
            {
                $validator_2 = $request->validate([
                    'image' => 'mimes:jpeg,bmp,png,jpg' // Only allow .jpg, .bmp and .png file types.
                ]);
                //save image in folder
                $file_extention = $request->image->getClientOriginalExtension();
                $file_name = time(). '.' .$file_extention;
                $file_path = 'images/users' ;  //get image path
                $request->image->move($file_path,$file_name);
            }
            $x = $user->create([
                'name' => $data['name'],
                'image' => $file_name,
                'username' => $data['username'],
                'region' => $data['region'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            // $token = $user->createToken($request->token_name);
            // $token = $x->createToken('marketProjectToken')->plainTextToken;
            $response =[
                'message' => 'Sign Up successfully',
                'user' => $x,
                // 'token' => $token
            ];
            return response()->json($response, 201);
        }
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $userconnection = new User;
        $userconnection->setConnection('mysql');
        $user = User::where('email',$data['email'])->first(); //check if email exist in DB1 -> mysql
        if( !$user )
        {
            $user = $userconnection->setConnection('mysql_2');
            $user = $userconnection->where('email',$data['email'])->first(); //check if email exist in DB1 -> mysql_2
            if( !$user || !Hash::check($data['password'], $user->password) )
                {
                    return response(['message' => 'Invalid Credintials',],401);
                }
                else
                {
                    $token = $user->createToken('marketProjectToken')->plainTextToken;
                    $response =[
                        'user' => $user,
                        'token' => $token
                    ];
                    return response($response, 200);
                }
        }
        else
        {
            $token = $user->createToken('marketProjectToken')->plainTextToken;
            $response =[
                'user' => $user,
                'token' => $token
            ];
            return response($response, 200);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logged Out Successfully',
        ]);
    }
}
