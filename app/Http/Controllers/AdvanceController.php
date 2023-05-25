<?php


namespace App\Http\Controllers;

use App\Advance;
use App\User;
use Illuminate\Http\Request;

Class AdvanceController extends Controller{

    public function advance(){

        $advance=Advance::all();

        return view('advance',['title'=>'Advance Percentage','advance' =>$advance]);
        
    }

    public function save(Request $request){

        $advancePercentage=$request['advancePercentage'];
    
        $validator = \Validator::make($request->all(), [

            'advancePercentage' => 'required'
        ], [
            'advancePercentage.required' => 'Percentage should be provided!',
    
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        
                
            $save=new Advance();
            $save->advance_percentage=$advancePercentage;
            $save->save();
               
           return \response()->json(['success'=>'Record saved successfully']);
    }

    public function delete(Request $request){
        $advanceId=$request['advanceId'];
        $delete = Advance::find($advanceId);
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }
    
}

