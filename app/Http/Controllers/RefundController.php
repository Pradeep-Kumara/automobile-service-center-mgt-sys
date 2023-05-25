<?php


namespace App\Http\Controllers;

use App\Refund;
use App\User;
use Illuminate\Http\Request;

Class RefundController extends Controller{

    public function refund(){

        $refund=Refund::all();

        return view('refund',['title'=>'Refund','refund' =>$refund]);
        
    }

    public function save(Request $request){

        $refundAmount=$request['refundAmount'];
    
        $validator = \Validator::make($request->all(), [

            'refundAmount' => 'required'
        ], [
            'refundAmount.required' => 'Amount should be provided!',
    
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        
                
            $save=new Refund();
            $save->refund_amount=$refundAmount;
            $save->save();
               
           return \response()->json(['success'=>'Record saved successfully']);
    }

    public function delete(Request $request){
        $refundId=$request['refundId'];
        $delete = Refund::find($refundId); //'find' automatically takes the primary  and match it with categoryId which we get from blade file
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }
    
}

