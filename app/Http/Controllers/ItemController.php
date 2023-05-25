<?php
namespace App\Http\Controllers;


use App\Category;
use App\Item;
use App\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{

    public function itemIndex(){

        $itemView=Item::all();
        $categoryView=Category::where('category_status',1)->get();
        $uomView=Uom::all();
        return view('item',['title'=>'Item','itemView'=>$itemView,'categoryView'=>$categoryView, 'uomView'=>$uomView]);
        

    }

    public function save(Request $request)
    {

        $itemCategory = $request['itemCategory'];
        $itemName = $request['itemName'];
        $itemDescription=$request['itemDescription'];
        $itemOemCode = $request['itemOemCode'];
        $itemManufacturerCode = $request['itemManufacturerCode'];
        $itemUom=$request['itemUom'];
        $itemUnitCost = $request['itemUnitCost'];
        $itemUnitPrice = $request['itemUnitPrice'];
        $itemRemarks = $request['itemRemarks'];
                
        
        
        $validator = \Validator::make($request->all(), [

            
            'itemCategory' => 'required',
            'itemName' => 'required|max:45',
            'itemOemCode'=> 'required',
            'itemUom'=> 'required',
            'itemUnitCost' => 'required|not_in:0',
            'itemUnitPrice' => 'required|not_in:0',
           
        ], [
            
            'itemCategory.required' => 'Category should be provided',
            'itemName.required'     => 'Item name should be provided and must be less than 45 characters long',
            'itemOemCode.required'  => 'OEM code is mandatory',
            'itemUom.required'      => 'Unit of measure should be provided',
            'itemUnitCost.required' => 'Unit cost cannot be blank or zero',
            'itemUnitPrice.required'=> 'Unit price cannot be blank or zero',
           
        ]);

        if (Item::where('item_oem_code', $itemOemCode)->first()) {
            return response()->json(['errors' => ['error' => 'Item already exist. Cannot duplicate OEM code']]);
        }


        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()]);

        }

        $saveProduct = new Item();
        $saveProduct->item_category_id = $itemCategory;
        $saveProduct->item_short_description = $itemName;
        $saveProduct->item_long_description = $itemDescription;
        $saveProduct->item_oem_code = $itemOemCode;
        $saveProduct->item_manufacturer_code = $itemManufacturerCode;
        $saveProduct->item_uom_id = $itemUom;
        $saveProduct->item_unit_cost = $itemUnitCost;
        $saveProduct->item_unit_price = $itemUnitPrice;        
        $saveProduct->item_status = '1';
        $saveProduct->item_remarks = $itemRemarks;
        $saveProduct->save();

        
        return response()->json(['success' => 'Product saved successfully.']);
    }

    public function getById(Request $request){

        $itemId=$request['itemId'];
        $item=Item::find($itemId);

        return \response()->json($item);
    }

    public function update(Request $request){

        //$oemCode=$request['oemCode'];
        $manufacturerCode=$request['manufacturerCode'];
        $itemName=$request['itemName'];
        $itemDesc=$request['itemDesc'];
        $unitCost=$request['unitCost'];
        $unitPrice=$request['unitPrice'];
        $remarks=$request['remarks'];
        $hiddenItemId=$request['hiddenItemId'];
        
        $validator = \Validator::make($request->all(), [

            'manufacturerCode' => 'required',
            'itemName' => 'required',
            'unitCost' => 'required',
            'unitPrice' => 'required',
            
        ], [
            'manufacturerCode.required' => 'Manufacturer code cannot be blank!',
            'itemName.required' => 'Name cannot be blank!',
            'unitCost.required' => 'Unit cost cannot be blank!',
            'unitPrice.required' => 'Unit price cannot be blank!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' =>$validator->errors()->all()]);
        
        }
                
        $update=Item::find($hiddenItemId);
        $update->item_manufacturer_code=$manufacturerCode;
        $update->item_short_description=$itemName;
        $update->item_long_description=$itemDesc;
        $update->item_unit_cost=$unitCost;
        $update->item_unit_price=$unitPrice;
        $update->item_remarks=$remarks;
        $update->update();

        return \response()->json(['success'=>'Item updated successfully']);
    }

    public function viewItem(Request $request){
        $ItemId=$request['ItemId'];
        $getItemDetail=Item::find($ItemId);
        $getUomDetail=UOM::find($getItemDetail->item_uom_id);
        $getCategoryDetail=Category::find($getItemDetail->item_category_id);

            //return response()->json(['getItemDetail'=>$getItemDetail, 'getCustomerDetail'=>$getCustomerDetail]);
            return response()->json(['getItemDetail'=>$getItemDetail, 'getUomDetail'=>$getUomDetail, 'getCategoryDetail'=>$getCategoryDetail]);
    }


    public function updateItem(Request $request){
        $ItemId=$request['ItemId'];
        $getItemDetail=Item::find($ItemId);
        $getUomDetail=UOM::find($getItemDetail->item_uom_id);
        $getCategoryDetail=Category::find($getItemDetail->item_category_id);

            //return response()->json(['getItemDetail'=>$getItemDetail, 'getCustomerDetail'=>$getCustomerDetail]);
            return response()->json(['getItemDetail'=>$getItemDetail, 'getUomDetail'=>$getUomDetail, 'getCategoryDetail'=>$getCategoryDetail]);
    }

    public function delete(Request $request){
        $itemId=$request['itemId'];
        $delete = Item::find($itemId);
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }
}