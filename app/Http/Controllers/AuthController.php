<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationForm;
use App\User;
use App\Roll;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller{


    public function __construct(){
        $this->middleware('RedirectIfAuthenticate',['except'=>'logout']);
    }
    
    public function index(){
        return view('admin.login');
    }
    public function create(RegistrationForm $r){
        $data = [
            'full_name' => $r->full_name,
            'phone' => $r->phone,
            'email' => $r->email,
            'password' => Hash::make($r->password),
            'address' => $r->address,
            'roll_id' => $r->roll_id,
        ];
        if(User::create($data)){
            return redirect()->back()->with('redirect_message','Registration Successfull');
        }else{
            return redirect()->back()->with('redirect_message','Registration Fail');
        }
    }
    public function login(Request $r){
        if(Auth::attempt(['email'=>$r->email,'password'=>$r->password])){
            session(['user_id' => Auth::user()->id]);
            return redirect('admin');
        }else{
            return redirect()->back()->with('redirect_login_message',$r->email);
        }
    }
    public function ajax_login(Request $r){
        if(Auth::attempt(['email'=>$r->email,'password'=>$r->password])){
            return 1;
        }else{
            return 0;
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
    public function form(){
        return view('admin.form');
    }

    
}
