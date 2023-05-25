<?php
namespace App\Http\Controllers;


use App\Customer;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class VehicleController extends Controller
{

    public function vehicleIndex(){



        // $vehicleView=Vehicle::all();
        // $customerView=Customer::where('customer_status',1)->get();

        if(\Illuminate\Support\Facades\Auth::user()->user_role_id == 1 ){
            $customerId = Customer::where('customer_user_id', Auth::user()->user_id)->first();
            $vehicleView=Vehicle::where('vehicle_customer_id', $customerId->customer_id)->latest()->get();
            
        }else{
            $vehicleView=Vehicle::all();
            
        }
        
        
            $customerView=Customer::where('customer_status',1)->get();

        return view('vehicle',['title'=>'Vehicle','vehicleView'=>$vehicleView,'customerView'=>$customerView]);
        

    }

    public function save(Request $request)
    {
        $customer = $request['customer'];
        $regNumber=$request['regNumber'];
        $make = $request['make'];
        $model = $request['model'];
        $engine = $request['engine'];
        $chassis = $request['chassis'];
        $year=$request['year'];
        //$customer_id = $request['customer_id']; 
        $vehicleRemarks = $request['vehicleRemarks'];
        
        $validator = \Validator::make($request->all(), [

            'customer' => 'required',
            'regNumber' => 'required|max:7',
            'make'=> 'required',
            'model'=> 'required',            
           
        ], [
            'customer.required' => 'customer NIC is not valid',
            'regNumber.required'     => 'Registration should be provided and must be less than 45 characters long',
            'make.required'  => 'Make is required',
            'model.required'      => 'Model is required',
        ]);

        if (Vehicle::where('vehicle_registration_number', $regNumber)->first()) {
            return response()->json(['errors' => ['error' => 'Vehicle already exist in the system']]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);  

        }
                
        $saveVehicle = new Vehicle();
        $saveVehicle->vehicle_customer_id = $customer;
        $saveVehicle->vehicle_registration_number = $regNumber;
        $saveVehicle->vehicle_make = $make;
        $saveVehicle->vehicle_model = $model;
        $saveVehicle->vehicle_engine_number = $engine;
        $saveVehicle->vehicle_chassis_number = $chassis;
        $saveVehicle->vehicle_manufacture_year = $year;        
        $saveVehicle->vehicle_remarks = $vehicleRemarks;
        $saveVehicle->vehicle_status = '1';
        $saveVehicle->save();
        
        return response()->json(['success' => 'Vehicle saved successfully.']);
    }

    public function viewVehicle(Request $request){
        $vehicleID=$request['vehicleID'];
        $getVehicleDetail=Vehicle::find($vehicleID);
        $getCustomerDetail=Customer::find($getVehicleDetail->vehicle_customer_id);

            return response()->json(['getVehicleDetail'=>$getVehicleDetail, 'getCustomerDetail'=>$getCustomerDetail]);
    }

    public function viewCustomerName(Request $request){
        $customerID = $request['customerID'];
        $getCustomerName=Customer::find($customerID);
        return $getCustomerName;
    }

    // public function updateVehicleCustomer(Request $request){
    //     $customerID = $request['customerID'];
    //     $getCustomerName=Customer::find($customerID);
    //     return $getCustomerName;
    // }

    public function update(Request $request){

        $updateRegNumber=$request['updateRegNumber'];
        $updateMake=$request['updateMake'];
        $updateModel=$request['updateModel'];
        $updateEngine=$request['updateEngine'];
        $updateChassis=$request['updateChassis'];
        $updateYear=$request['updateYear'];
        $updateCustomer=$request['updateCustomer'];
        $updateRemarks=$request['updateRemarks'];
        $hiddenVehicleId=$request['hiddenVehicleId'];

        $validator = \Validator::make($request->all(), [

            'updateRegNumber' => 'required|max:8',
            'updateMake' => 'required',
            'updateModel' => 'required',
            'updateCustomer' => 'required',
            
        ], [
            'updateRegNumber.required' => 'Registration number cannot be blank and should be less than 8 characters!',
            'updateRegNumber.max' => 'Registration number should be less than 8 characters!',
            'updateMake.required' => 'Make cannot be blank!',
            'updateModel.required' => 'Model cannot be blank!',
            'updateCustomer.required' => 'Customer should be selected!',
        ]);

        if ($validator->fails()) {
            //return response()->json(['errors' =>$validator->errors()->all()]);
            return response()->json(['errors' =>$validator->errors()]);  
        }
                
        $update=Vehicle::find($hiddenVehicleId);
        $update->vehicle_registration_number=$updateRegNumber;
        $update->vehicle_make=$updateMake;
        $update->vehicle_model=$updateModel;
        $update->vehicle_engine_number=$updateEngine;
        $update->vehicle_chassis_number=$updateChassis;
        $update->vehicle_manufacture_year=$updateYear;
        $update->vehicle_customer_id=$updateCustomer;
        $update->vehicle_remarks=$updateRemarks;
        $update->update();

        return \response()->json(['success'=>'Vehicle updated successfully']);
    }

    public function delete(Request $request){
        $vehicleId=$request['vehicleId'];
        $delete = Vehicle::find($vehicleId);
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }

    public function getByVehicleId(Request $request){

        $vehicleId=$request['vehicleId'];
        $getVehicleDetails=Vehicle::find($vehicleId);
        $getCustomerDetails=Customer::find($getVehicleDetails->vehicle_customer_id);
            //return \response()->json($vehicle);
            return response()->json(['getVehicleDetails'=>$getVehicleDetails, 'getCustomerDetails'=>$getCustomerDetails]);
    }

}