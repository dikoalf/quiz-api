<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['desc', 'option1', 'option2', 'option3', 'option4', 'answer', 'score'];

    protected $table = 'quiz';

    function index($type)
    {
        if($type == 'all'){
            $quiz = Quiz::get();
        }else{
            $quiz = Quiz::limit(10)->inRandomOrder()->where('score', '<=', 100)->groupBy('id')->havingRaw('SUM(score) <= 100')->get();
        }

        return $quiz;
    }

    function show($id)
    {
        $quiz = Quiz::where('id', $id)->get()->first;
        
        return $quiz->first();
    }

    function createData($data)
    {
        DB::beginTransaction();
        
        try 
        {
            Quiz::insert($data);

            DB::commit();
            return null;
        }  catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    function updateData($id, $data)
    {
        DB::beginTransaction();
        
        try 
        {
            Quiz::findOrFail($id)->update([
                'desc' => $data['desc'],
                'option1' => $data['option1'],
                'option2' => $data['option2'],
                'option3' => $data['option3'],
                'option4' => $data['option4'],
                'answer' => $data['answer'],
                'score' => $data['score'],
            ]);

            DB::commit();
            return null;
        }  catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    function deleteData($id)
    {
        DB::beginTransaction();
        
        try 
        {
            Quiz::findOrFail($id)->delete();

            DB::commit();
            return null;
        }  catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}
