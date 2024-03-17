<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthManager extends Controller
{
    //
    function login()
    {
        if (Auth::check()) {
            return redirect(route("home"));
        }
        return view("login");
    }
    function registation()
    {
        return view("registation");
    }
    function loginPost(Request $request)
    {
        $request->validate(
            [
                "email" => "required|email",
                "password" => "required"
            ]
        );
        $credentials = $request->only("email", "password");
        if (Auth::attempt($credentials)) {
            return redirect(route("home"));
        }
        return redirect(route("login"))->with("error", "Login details is not valid");
    }

    function registationPost(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);
        $data["name"] = $request->name;
        $data["email"] = $request->email;
        $data["password"] = Hash::make($request->password);
        $user = User::create($data);
        if (!$user) {
            return redirect(route("registation"))->with("error", "Registation failed, try again");
        }
        return redirect(route("login"))->with("success", "Successfully sign up, Log in to access the app");
    }
    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route("login"));
    }
}