<?php


namespace App\Http\Controllers;


use App\UOM;
use App\Measurement;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UomController extends Controller
{
    public function uomIndex(Request $request){

        //$paginate = 10;
        //$keyword = $request['search'];
       // $column = '';
        
        $uomView=UOM::all();

        return view('uom',['title'=>'Unit Of Measure','uomView'=>$uomView]);
    }

    public function save(Request $request){

        $saveUomCode=$request['saveUomCode'];
        $saveUomDesc=$request['saveUomDesc'];
               

        $validator = \Validator::make($request->all(), [

            'saveUomCode' => 'required',
            'saveUomDesc' => 'required|max:200',
            
        ], [
            'saveUomCode.required' => 'UOM should be provided!',
            'saveUomDesc.max' => 'UOM description must be less than 200 characters.',
            'saveUomDesc.required' => 'UOM description should be provided',
    
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $save=new Uom();
        $save->uom_code = $saveUomCode;
        $save->uom_description = $saveUomDesc;
        $save->save();
        
       return \response()->json(['success'=>'UOM saved successfully']); //return a json array //y jason array?????
    }

    public function getById(Request $request){

        $uomId=$request['uomId'];
        $getUomDetail=Uom::find($uomId);

            return \response()->json($getUomDetail);
    }

    public function update(Request $request){

        $hiddenUomId=$request['hiddenUomId'];
        $updateUomDesc=$request['updateUomDesc'];

        $validator = \Validator::make($request->all(), [

            'updateUomDesc' => 'required|max:200',
        ], [
            'updateUomDesc.required' => 'UOM description should be provided!',
            'updateUomDesc.max' => 'UOM description must be less than 200 characters long.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
       
        $update=Uom::find($hiddenUomId);
        $update->uom_description=$updateUomDesc;
        $update->update();

        return \response()->json(['success'=>'UOM updated successfully']);
    }

    public function delete(Request $request){
        $uomID=$request['uomID'];
        $delete = Uom::find($uomID);

        $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    

    public function view(Request $request){

        $uomID=$request['uomID'];
        $getUomDetail=UOM::find($uomID);
        
        return response()->json(['getUomDetail'=> $getUomDetail]);
    }

}