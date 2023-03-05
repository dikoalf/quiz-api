<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory, Notifiable, hasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'level', 'token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    function index()
    {
        $user = Users::get();

        return $user;
    }

    function show($id)
    {
        $user = Users::where('id', $id)->get()->first;
        
        return $user->first();
    }

    function createData($data)
    {
        DB::beginTransaction();
        
        try 
        {
            $user = Users::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'level' => '2',
            ]);

            DB::commit();
            return $user;
        }  catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    function updateData($id, $data)
    {
        DB::beginTransaction();
        
        try 
        {
            Users::findOrFail($id)->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'level' => $data['level'],
                'remember_token' => $data['token'],
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
            Users::findOrFail($id)->delete();

            DB::commit();
            return null;
        }  catch (\Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
}
