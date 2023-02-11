<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginaksi(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $user = User::where('email', $request->email)
        ->get();
        if($user){
            if($user[0]['role'] == "admin"){
                if (Auth::Attempt($data)) {
                    return redirect()->route('home');
                } else {
                    return redirect('/');
                }
            }else if ($user[0]['role'] == "customer"){
                if (Auth::Attempt($data)) {
                    return redirect()->route('customer');
                } else {
                    return redirect('/');
                }
            }
        }else{
            Session::flash('error', 'User tidak terdaftar');
        }
        // if (Auth::Attempt($data)) {
        //     return redirect()->route('customer');
        // } else {
        //     Session::flash('error', 'Email atau Password Salah');
        //     return redirect('/');
        // }
    }

    public function logoutaksi()
    {
        Auth::logout();
        return redirect('/');
    }


    public function viewForgot()
    {
        return view('auth.forgot');
    }

    public function forgot(Request $request)
    {

        $request->validate(['email' => 'required|email']);
        $user = User::where('role', 'customer')->where('email', $request->email)->firstOrFail();
        $token = base64_encode(Uuid::uuid4());
        $tokenUser = Token::create([
            'user' => json_encode($user),
            'token' => $token,
            'expired_date' => Carbon::now()->add(4, 'hour'),
            'status' => 0
        ]);
        Mail::to($request->email)->send(new ResetPassword($tokenUser));
        return redirect()->route('view-verify');
    }


    public function token()
    {
        return view('mail.verify');
    }

    public function verifyToken(Request $request)
    {
        $token = Token::where('token', $request->token)->where('expired_date', '>', Carbon::now())->first();
        $token->status = 1;
        $token->save();
        if (!$token) {
            return redirect()->route('forgot')->with('error', 'Generate kembali token');
        }
        $user = json_decode($token->user);
        return view('auth.verify', [
            'user_id' => $user->id
        ]);
    }

    public function updatePassword(Request $request)
    {
        User::where('id', $request->user_id)->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('login')->with('success', 'Silakan loggin kembali');
    }
}