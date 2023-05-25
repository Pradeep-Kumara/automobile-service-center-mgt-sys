<?php
namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function login(Request $request)    {
        $this->validate($request, ['username' => 'required', 'password' => 'required|min:3'],
    
        [
            'username.required' => 'Username should be provided!',
            'password.required' => 'Password should be provided!',
            'password.max' => 'Username must be more than 8 characters long.',
        ]);

        $advanceEncryption=(new  \App\MyResources\AdvanceEncryption($request->get('password'),"Nova6566",256));       

        $user = User::where('user_name', $request->get('username'))->where('user_password',$advanceEncryption->encrypt())->exists();       
        if ($user==true){
            $userData = User::where('user_name', $request->get('username'))->where('user_password',$advanceEncryption->encrypt())->first();       
           
            if ($userData->user_status==1){
                Auth::login($userData);
                return redirect('/');
            }else if($userData->user_status==0){
                return back()->with('warning', 'User has been suspended! Contact Stephen\'s Pvt Ltd, 072-720-3577.');
            }
        }
        
        else{
            return back()->with('error', 'Incorrect login details! Check Username and Password');
        }
    }
    public function logout(Request $request){
        $request->session()->invalidate();
        return redirect('/signin');
    }
    public function signup(){
        return view('signup');
    }
}
