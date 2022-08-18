<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;


class UserController extends Controller
{
    use ApiResponser;

    public function showCurrentUser()
    {
        return auth()->user();
    }

    public function updateCurrentUser(Request $request)
    {
        $user = auth()->user();
        User::where('id', $user->id)->update($request->all());

        return $this->success("Successfully updated user ID {$user['id']}");
    }
}
