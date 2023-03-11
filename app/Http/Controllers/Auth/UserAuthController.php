<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{

    public function register(Request $request)
    {
        $errorMessage = '';
        $response = [];

        try
        {
            $data = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                // 'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);

            if(empty(Users::getEmail($request['email'])))
            {
                $user = Users::createData($data);

                $response['data'] = new UsersResource($user);
            }
            else
            {
                $errorMessage = 'Email already exist';
            }
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }

        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = empty($errorMessage) ? 'Data successfully saved' : $errorMessage;

        return $response;
    }

    public function login(Request $request)
    {
        $errorMessage = '';
        $response = [];

        try
        {
            $data = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);
    
            if(Auth::guard('web')->attempt(['email' => request('email'), 'password' => request('password')]))
            {
                $user = Auth::guard('web')->user();

                $response['data'] = new UsersResource($user);
                $response['token'] = $user->createToken('API Token')->accessToken;
            }
            else 
            {
                $errorMessage = 'Incorrect Details. 
                Please try again';
            }
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }

        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = empty($errorMessage) ? 'Login Success' : $errorMessage;

        return $response;
    }
}