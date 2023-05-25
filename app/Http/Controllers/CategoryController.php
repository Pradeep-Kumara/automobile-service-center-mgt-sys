<?php


namespace App\Http\Controllers;


use App\Category;
use App\Customer;
use App\Measurement;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function categoriesIndex(Request $request){

        $paginate = 10;
        $keyword = $request['search'];
        $column = '';
        
        $categories=Category::all();

        return view('category',['title'=>'Categories', 'categories'=>$categories]);
    }

    public function save(Request $request){

        $category=$request['category'];
        $categoryDescription=$request['categoryDescription'];
    

        $validator = \Validator::make($request->all(), [

            'category' => 'required|max:20|regex:/^[\w-]*$/'  // /^\d{9}CCC$/   /(01)[a-zA-Z]{9}/
        ], [
            'category.required' => 'Category should be provided!',
            'category.max' => 'Category must be less than 20 characters long.',
            'category.regex' => 'Category cannot have space and symbols',
    
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $categoryExist = Category::where('category_short_description', strtoupper($category))->first();

        if($categoryExist!=null){

            return \response()->json(['errors' => ['arrayLength' => 'Category already exist.']]); // 'array inside an array' - cleared
        }

        $save=new Category();
        $save->category_short_description=strtoupper($category);
        $save->category_long_description=$categoryDescription;
        $save->category_status='1';
        //$save->master_user_idmaster_user=Auth::user()->idmaster_user;
        //$save->master_company=Auth::user()->master_company;
        $save->save();

        //$tableData='';
        //$categories=Category::where('master_company',Auth::user()->master_company)->orderBy('created_at', 'desc')->paginate(10);

        
       return \response()->json(['success'=>'Category saved successfully']);
    }

    public function getById(Request $request){

        $categoryId=$request['categoryId'];

        $category=Category::find($categoryId);

        return \response()->json($category);
    }

    public function update(Request $request){

        $updateCategoryDescription=$request['updateCategoryDescription'];
        $hiddenCategoryId=$request['hiddenCategoryId'];
        $validator = \Validator::make($request->all(), [

            'updateCategoryDescription' => 'required|max:200',
        ], [
            'updateCategoryDescription.required' => 'Category description should be provided!',
            'updateCategoryDescription.max' => 'Category description must be less than 200 characters long.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
       
        $update=Category::find($hiddenCategoryId);
        $update->category_long_description=$updateCategoryDescription;
        $update->update();

        return \response()->json(['success'=>'Category updated successfully']);
    }

    public function delete(Request $request){
        $categoryId=$request['categoryId'];
        $delete = Category::find($categoryId); 
        if($delete!=null){
            $delete->delete();
            
            return response()->json(['success' => 'Deleted successfully.']);
        }
    }

    public function view(Request $request){
        $categoryId=$request['categoryId'];
        $getCategoryDetail=Category::find($categoryId);
        //$getCustomerDetail=Customer::find($getVehicleDetail->vehicle_customer_id);

        //return response()->json(['getCategoryDetail'=>$getCategoryDetail]);
        return response()->json($getCategoryDetail);
    }

}