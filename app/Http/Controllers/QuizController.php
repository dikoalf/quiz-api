<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Http\Resources\QuizResource;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $errorMessage = "";
        $data = [];

        try
        {
            $data = Quiz::index($request['type']);
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }

        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = $errorMessage;
        $response['data'] = !empty($data) ? QuizResource::collection($data) : '';

        return $response;
    }

    public function show($id)
    {
        $errorMessage = "";
        $data = [];

        try 
        {
            $data = Quiz::show($id);
        } 
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }

        $response['code'] = !empty($data) ? '00' : '04';
        $response['message'] = !empty($data) ? '' : 'Data not found';
        $response['data'] = !empty($data) ? new QuizResource($data) : '';

        return $response;
    }
    

    public function create(Request $request)
    {
        $errorMessage = "";
        
        try
        {
            $data = json_decode($request['data'], true);

            $quiz = Quiz::createData($data);
            
            $errorMessage = empty($quiz) ? "" : $quiz;
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }
        
        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = empty($errorMessage) ? 'Data successfully saved' : $errorMessage;

        return $response;
    }

    public function update(Request $request, $id)
    {
        $errorMessage = "";

        try
        {
            $quiz = Quiz::updateData($id, $request);
            
            $errorMessage = empty($quiz) ? "" : $quiz;
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
        }
        
        $response['code'] = empty($errorMessage) ? '00' : '04';
        $response['message'] = empty($errorMessage) ? 'Data successfully updated' : 'Failed to update data';

        return $response;
    }

    public function destroy($id)
    {
        $errorMessage = "";

        try
        {
            $quiz = Quiz::deleteData($id);
            
            $errorMessage = empty($quiz) ? "" : $quiz;
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
