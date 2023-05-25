<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Category;
use App\Customer;
use App\Item;
use App\Vehicle;
use App\Task;




use Illuminate\Http\Request;

class CommonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function activateDeactivate(Request $request)
    {

   
        $id = $request['id'];
        $table = $request['table'];

        if ($table == "customer") {

            $table = Customer::find($id);
            if ($table->customer_status == 1) {
                $table->customer_status = 0;
            } else {
                $table->customer_status = 1;
            }
            $table->update();

        }
      
        if ($table == "category") {

            $table = Category::find($id);
            if ($table->category_status == 1) {
                $table->category_status = 0;
            } else {
                $table->category_status = 1;
            }
            $table->update();

        }

        if ($table == "item") {

            $table = Item::find($id);
            if ($table->item_status == 1) {
            $table->item_status = 0;
            } else {
            $table->item_status = 1;
            }
            $table->update();

        }

        if ($table == "vehicle") {

            $table = Vehicle::find($id);
            if ($table->vehicle_status == 1) {
            $table->vehicle_status = 0;
            } else {
            $table->vehicle_status = 1;
            }
            $table->update();

        }

        if ($table == "task") {

            $table = Task::find($id);
            if ($table->task_status == 1) {
            $table->task_status = 0;
            } else {
            $table->task_status = 1;
            }
            $table->update();

        }

        if ($table == "user") {

            $table = User::find($id);
            if ($table->user_status == 1) {
            $table->user_status = 0;
            } else {
            $table->user_status = 1;
            }
            $table->update();

        }
       
    
    }
    

}
