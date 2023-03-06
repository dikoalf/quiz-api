<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
    // GET
    public function index()
    {
        $errorMessage = "";
        $data = [];

        try
        {
            $data = Users::index();
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }

        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = $errorMessage;
        $response['data'] = !empty($data) ? UsersResource::collection($data) : '';

        return $response;
    }

    public function show($id)
    {
        $errorMessage = "";
        $data = [];

        try 
        {
            $data = Users::show($id);
        } 
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }

        $response['code'] = !empty($data) ? '00' : '04';
        $response['message'] = !empty($data) ? '' : 'Data not found';
        $response['data'] = !empty($data) ? new UsersResource($data) : '';

        return $response;
    }

    // PUT

    public function update(Request $request, Users $Users)
    {
        $errorMessage = "";

        try
        {
            $user = Users::createData($request);
            
            $errorMessage = empty($user) ? "" : $user;
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }
        
        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = empty($errorMessage) ? 'Data successfully updated' : 'Failed to update data';

        return $response;
    }

    // DELETE

    public function destroy($id)
    {
        $errorMessage = "";

        try
        {
            $user = Users::deleteData($id);
            
            $errorMessage = empty($user) ? "" : $user;
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }
        
        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = empty($errorMessage) ? 'Data successfully deleted' : $errorMessage;

        return $response;
    }
}
