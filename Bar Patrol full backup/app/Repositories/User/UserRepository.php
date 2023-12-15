<?php

namespace App\Repositories\User;

use App\Repositories\User\UserInterface;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Address;
use Auth;

class UserRepository implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store($request)
    {
        $request["password"] = Hash::make($request["password"]);
        return User::create($request);
    }

    // /*
    // * Function to update optional addon
    // */
    // public function update($request)
    // {
    //     $user = User::findOrFail(session('user_id'));
    //     $request->session()->put('name', $request->name);
    //     return $user->update(["name" => $request->name,"password" => Hash::make($request->password)]);
    // }

    /*
    * Function to update optional addon
    */
    public function update($request, $where)
    {
        // return User::update($request)->where($where);
        return $this->user::where($where)->update($request);
    }
}
