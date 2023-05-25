<?php


namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;

class UserController extends Controller


{
    
    public function userIndex(){

        $userView = User::all();
        $roleView = UserRole::all();
            return view ('user', ['title' => 'User' , 'userView' =>$userView , 'roleView' =>$roleView]);
    }
       
    
    
    public function saveUser(Request $request){

        $validator = \Validator::make($request->all(), [

            'fName' => 'required|max:115',
            'lName' => 'required|max:115',
            'email' => 'required',
            'contactNo' => 'required|max:10|min:10',
            'nicNo' => 'required',
            'password' => 'required|min:9',

        ], [
            'fName.required' => 'First Name should be provided!',
            'email.required' => 'Email should be provided!',
            'fName.max' => 'Last Name must be less than 115 characters.',
            'lName.required' => 'Last Name should be provided!',
            'lName.max' => 'Last Name must be less than 115 characters.',
            'contactNo.required' => 'Contact No should be provided!',
            'contactNo.max' => 'Contact No must be include 10 number.',
            'contactNo.min' => 'Contact No must be include 10 number.',
            'nicNo.required' => 'NIC should be provided!',
            'password.max' => 'Password must be include 9 number.',
            'password.required' => 'Password should be provided.',

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['password'],"Nova6566", 256));

        $saveUser = new User();

        $saveUser->user_name = strtoupper($request['nicNo']);
        $saveUser->user_mobile_number = $request['contactNo'];
        $saveUser->user_password = $advanceEncryption->encrypt();
        $saveUser->user_status = 1;
        $saveUser->user_role_id = 1;

        $saveUser->save();

        $saveCustomer=new Customer();

        $saveCustomer->customer_firstname=strtoupper($request['fName']);
        $saveCustomer->customer_lastname=strtoupper($request['lName']);
        $saveCustomer->customer_mobile=$request['contactNo'];
        $saveCustomer->customer_email=strtolower($request['email']);
        $saveCustomer->customer_nic=$request['nicNo'];        
        $saveCustomer->customer_password=$advanceEncryption->encrypt();
        $saveCustomer->customer_status=1;        
        $saveCustomer->customer_user_id=$saveUser->user_id;
        $saveCustomer->save();     



        return response()->json(['success' => 'Customer saved successfully.']);
    }

    public function createUser(Request $request){


        $saveUsername = $request['saveUsername'];
        $saveMobile=$request['saveMobile'];
        $savePassword = $request['savePassword'];
        $saveRole = $request['saveRole'];
        
        $validator = \Validator::make($request->all(), [

            'saveUsername' => 'required|min:5',
            'saveMobile' => 'required|max:10|min:10',
            'savePassword' => 'required|min:5',
            'saveRole' => 'required',
            

        ], [
            
            
            'saveUsername.required' => 'User name should be provided!',
            'saveUsername.min' => 'User name must be minimum 5 characters',
            'saveMobile.required' => 'Mobile number should be provided!',
            'saveMobile.max' => 'Mobile number should be 10 digits.',
            'saveMobile.min' => 'Mobile number should be 10 digits.',
            'savePassword.required' => 'Passworde should be provided!',
            'savePassword.min' => 'Password requires minimum 5 charaters!',
            'saveRole.required' => 'Select the user role',
            
            

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['savePassword'],"Nova6566", 256));

        $saveUser = new User();

        $saveUser->user_name = $saveUsername;
        $saveUser->user_mobile_number = $saveMobile;
        $saveUser->user_password = $advanceEncryption->encrypt();
        $saveUser->user_status = 1;
        $saveUser->user_role_id = $saveRole;

        $saveUser->save();
          
         return response()->json(['success' => 'User saved successfully.']);

    }


    public function deleteUser(Request $request){
        $userId=$request['userId'];
        $delete = User::find($userId);
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }

    public function getByUserId(Request $request){

        $userID=$request['userID'];
        $user=User::find($userID);
            return \response()->json($user);
    }

    public function updateUser(Request $request){

        $hiddenUserId=$request['hiddenUserId'];
        $updateUsername=$request['updateUsername'];
        $updatePassword=$request['updatePassword'];

        $validator = \Validator::make($request->all(), [

            'updateUsername' => 'required|min:5',
            'updatePassword' => 'required|min:5',
            

        ], [
            'updateUsername.required' => 'User name should be provided!',
            'updateUsername.min' => 'User name must be minimum 5 characters',
            'updatePassword.required' => 'Passworde should be provided!',
            'updatePassword.min' => 'Password requires minimum 5 charaters!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['updatePassword'],"Nova6566", 256));
       
        $update=User::find($hiddenUserId);
        $update->user_name=$updateUsername;
        $update->user_password=$advanceEncryption->encrypt();
        $update->update();

        return \response()->json(['success'=>'Username and password updated successfully']);
    }
    
}