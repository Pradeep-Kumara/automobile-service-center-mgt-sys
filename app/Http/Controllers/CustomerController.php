<?php

namespace App\Http\Controllers;
use App\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{

    public function customerIndex(){

        $customerView=Customer::all();        
            return view('customer',['title'=>'Customer','customerView'=>$customerView]);
            //return view('customer',['title'=>'Customer']);

    }

    public function saveCustomer(Request $request){

        $nic = $request['nic'];
        $firstname=$request['firstname'];
        $lastname = $request['lastname'];
        $address = $request['address'];
        $mobile = $request['mobile'];
        $email = $request['email'];


        $validator = \Validator::make($request->all(), [

            'nic' => 'required|max:11|min:10',
            'firstname' => 'required|max:115',
            'lastname' => 'max:115',
            'mobile' => 'required|max:10|min:10',
            'email'=> 'email',

        ], [
            
            
            'nic.required' => 'NIC should be provided!',
            'nic.max' => 'NIC must be between 10 - 11 characters',
            'nic.min' => 'NIC must be between 10 - 11 characters',
            'firstname.max' => 'First Name must be less than 115 characters.',
            'firstname.required' => 'First Name should be provided!',
            'lastname.max' => 'Last Name must be less than 115 characters.',
            'mobile.required' => 'Mobile number should be provided!',
            'mobile.max' => 'Mobile number should be 10 digits.',
            'mobile.min' => 'Mobile number should be 10 digits.',
            'email' => 'Email is not valid',
            

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $advanceEncryption = (new  \App\MyResources\AdvanceEncryption($request['nic'],"Nova6566", 256));

        $saveUser = new User();

        $saveUser->user_name = strtoupper($request['nic']);
        $saveUser->user_mobile_number = $request['mobile'];
        $saveUser->user_password = $advanceEncryption->encrypt();
        $saveUser->user_status = 1;
        $saveUser->user_role_id = 1;

        $saveUser->save();
        
        $saveCustomer=new Customer();

        $saveCustomer->customer_nic=$request['nic'];
        $saveCustomer->customer_firstname=strtoupper($request['firstname']);
        $saveCustomer->customer_lastname=strtoupper($request['lastname']);

        $saveCustomer->customer_address=$request['address'];
        //$saveCustomer->customer_address_line2=$request['street'];
        //$saveCustomer->customer_address_line3=$request['city'];

        $saveCustomer->customer_mobile=$request['mobile'];
        $saveCustomer->customer_email=strtolower($request['email']);                
        $saveCustomer->customer_password=$advanceEncryption->encrypt();
        $saveCustomer->customer_status=1;        
        $saveCustomer->customer_user_id=$saveUser->user_id;
        $saveCustomer->save();     

        return response()->json(['success' => 'Customer saved successfully.']);

    }

    public function viewCustomer(Request $request){
        $customerId=$request['customerId'];
        $customer=Customer::find($customerId);

            return response()->json(['customer'=>$customer]);
    }

    public function deleteCustomer(Request $request){
        $customerId=$request['customerId'];
        $delete = Customer::find($customerId);
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }


    // public function update(Request $request){
    //     $customerID=$request['customerID'];
    //     $getCustomerDetail=Customer::find($customerID);
    //     //$getUomDetail=UOM::find($getItemDetail->item_uom_id);
    //     //$getCategoryDetail=Category::find($getItemDetail->item_category_id);

    //     return response()->json(['getCustomerDetail'=>$getCustomerDetail]);    
    //     //return response()->json(['getCustomerDetail'=>$getCustomerDetail, 'getUomDetail'=>$getUomDetail, 'getCategoryDetail'=>$getCategoryDetail]);
    // }

    public function getByCustomerId(Request $request){

        $customerID=$request['customerID'];
        $getCustomerDetail=Customer::find($customerID);

        return \response()->json($getCustomerDetail);
    }


    public function updateCustomer(Request $request){

        $updateNic = $request['updateNic'];
        $updateFirstName=$request['updateFirstName'];
        $updateLastName = $request['updateLastName'];
        $updateAddress = $request['updateAddress'];
        $updateMobile = $request['updateMobile'];
        $updateEmail = $request['updateEmail'];
        $hiddenCustomerId = $request['hiddenCustomerId'];
       

        $validator = \Validator::make($request->all(), [

            'updateNic' => 'required|max:11|min:10',
            'updateFirstName' => 'required|max:115',
            'updateLastName' => 'max:115',
            'updateMobile' => 'required|max:10|min:10',
            'updateEmail'=> 'email',

        ], [
                       
            'updateNic.required' => 'NIC should be provided!',
            'updateNic.max' => 'NIC must be between 10 - 11 characters',
            'updateNic.min' => 'NIC must be between 10 - 11 characters',
            'updateFirstName.max' => 'First Name must be less than 115 characters.',
            'updateFirstName.required' => 'First Name should be provided!',
            'updateLastName.max' => 'Last Name must be less than 115 characters.',
            'updateMobile.required' => 'Mobile number should be provided!',
            'updateMobile.max' => 'Mobile number should be 10 digits.',
            'updateMobile.min' => 'Mobile number should be 10 digits.',
            'updateEmail' => 'Email is not valid',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()->all()]);

        }

        
        $update = Customer::find($hiddenCustomerId);
        $update->customer_nic= $updateNic;
        $update->customer_firstname= $updateFirstName;
        $update->customer_lastname= $updateLastName;
        $update->customer_address= $updateAddress;
        $update->customer_mobile= $updateMobile;
        $update->customer_email= $updateEmail;
                
        //$updateCustomer->customer_password=$advanceEncryption->encrypt();
        //$updateCustomer->customer_status=1;        
        //$updateCustomer->customer_user_id=1;
        // /(01)[0-9]{9}/
        $update->update();     

        return response()->json(['success' => 'Customer saved successfully.']);

    }
}