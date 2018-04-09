<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class signup extends Controller
{
   public function index(Request $request)
   {

   	$id = $request->session()->get('id');


   	if ($id) {
 	  		return view('dashboard');
   	}else{
   			return view('signup');
   	}
   }



   public function login()
   {
   	return view('login');
   }

   public function post(Request $request)
   {
   	
   	if (isset($_REQUEST['submit'])) {
   		$data['name'] = $request->input('name');
   		$data['email'] = $request->input('email');
   		$data['username'] = $request->input('username');
   		$data['password'] = md5($request->input('password'));
   		
   		
   		$insert = DB::table('users')->insert($data);
   		
   		if ($insert == true) {
   		
   			
   		$message = "Sucessfully signed up";

   		return view('signup',compact('message'));
   		}
   	}
   }


   public function loginCheck(Request $request)
   {
   	if (isset($_REQUEST['login'])) {

   		$data['email'] = $request->input('email');
   		$data['password'] = md5($request->input('password'));

   		$check = DB::table('users')->where('email', '=', $data['email'])->where('password', '=', $data['password'])->get();

   		if ($check->count() == 1) {
   			
   			$id = $check->first()->id;
   			$name = $check->first()->name;
   			$email = $check->first()->email;

   			$request->session()->put('id', $id);
   			$request->session()->put('name', $name);
   			$request->session()->put('email', $email);

   			
		 return view('dashboard');
	   		
   		}else{

   			$message = 'It seems your username or password is wrong!';
  		 	return view('login',compact('message'));
   			
   		}
	}
   }


   public function logout(Request $request)
   {
   	$request->session()->flush();
		 return redirect('/login');

   }
}
