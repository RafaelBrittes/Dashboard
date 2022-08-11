<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;


class UserController extends Controller
{
    use ApiResponser;

    public function showUser(){
        return auth()->user();
    }

    public function updateUser(Request $request){
        User::where('id', $request->id)->update($request->all());
        $user = auth()->user();

        return $this->success("Successfully updated user ID {$user['id']}");
    }
}