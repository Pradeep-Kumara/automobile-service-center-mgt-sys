<?php


namespace App\Http\Controllers;

use App\Customer;
use App\Item;
use App\JobCard;
use App\JobItemDetail;
use App\JobItemDetailTemp;
use App\JobSchedule;
use App\JobTaskDetail;
use App\JobTaskDetailTemp;
use App\Order;
use App\OrderItem;
use App\OrderItemTemp;
use App\OrderTask;
use App\OrderTaskTemp;
use App\Shedule;
use App\Task;
use App\User;
use App\Vehicle;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function Index(){
   

    if(\Illuminate\Support\Facades\Auth::user()->user_role_id == 1 ){
        $customerId = Customer::where('customer_user_id', Auth::user()->user_id)->first();
        $jobCards=JobCard::where('jobcard_customer_id', $customerId->customer_id)->latest()->get();
        
    }else{
        $jobCards=JobCard::latest()->get();
    }

     return view('job-payment',['title'=>'Payment','jobCards'=>$jobCards]);
    }



    public function viewJobTableData(Request $request){

        $orderItem=JobItemDetailTemp::where('job_item_user_id',Auth::user()->user_id)->latest()->get();

        $tableData="";
        $total=0;

        $tableData2="";
        $totalService=0;

        if(count($orderItem)==0){
            $tableData .= "<tr>";
            $tableData .= "<td colspan='4' style='text-align:center'>" . 'Sorry No Results Found'. "</td>";
            $tableData .= "<tr>";
        }else{
            foreach ($orderItem as $order) {

                $total += $order->job_item_temp_price * $order->job_item_temp_quantity;
                $tableData .= "<tr>";
                $tableData .= "<td>" . $order->Item->item_short_description. "</td>";
                $tableData .= "<td>" . $order->job_item_temp_quantity. "</td>";
                $tableData .= "<td>" . number_format($order->job_item_temp_price, 2)."</td>";
               $tableData .= "<td>";
               $tableData .= "<button type='button'  class='btn btn-sm btn-info  waves-effect waves-light'  data-target=\"#viewItemModal\" data-toggle=\"modal\"   data-id='$order->job_item_temp_line_id'   id='viewItem' > ";
               $tableData .= " <i class=\"fa fa-eye\"></i>";
               $tableData .= "  </button>";
               $tableData .= "&nbsp;";
               $tableData .= "<button type='button'  class='btn btn-sm btn-danger  waves-effect waves-light'  onclick=deleteItem($order->job_item_temp_line_id) > ";
               $tableData .= " <i class=\"fa fa-trash\"></i>";
               $tableData .= "  </button>";
                $tableData .= " </td>";
                $tableData .= "</tr>";
            }
        }
        

        $orderTasks=JobTaskDetailTemp::where('job_task_user_id',Auth::user()->user_id)->latest()->get();
        
        if(count($orderTasks)==0){
            $tableData2 .= "<tr>";
            $tableData2 .= "<td colspan='4' style='text-align:center'>" . 'Sorry No Results Found'. "</td>";
            $tableData2 .= "<tr>";
        }else{
        $taskTime=0;
        foreach ($orderTasks as $order) {

            $taskTime+=$order->job_task_temp_duration;
            $totalService += $order->job_task_temp_price*$order->job_task_temp_duration;
            $tableData2 .= "<tr>";
            $tableData2 .= "<td>" . $order->Task->task_short_description. "</td>";
            $tableData2 .= "<td>" . $order->job_task_temp_duration. "</td>";
            $tableData2 .= "<td>" . number_format($order->job_task_temp_price, 2)."</td>";
           $tableData2 .= "<td>";
        
            $tableData2 .= "<button type='button'  class='btn btn-sm btn-info  waves-effect waves-light'  data-target=\"#viewTaskModal\" data-toggle=\"modal\"   data-id='$order->job_task_temp_line_id'   id='viewTask' > ";
            $tableData2 .= " <i class=\"fa fa-eye\"></i>";
            $tableData2 .= "  </button>";
            $tableData2 .= "&nbsp;";
            $tableData2 .= "<button type='button'  class='btn btn-sm btn-danger  waves-effect waves-light'  onclick=deleteTask($order->job_task_temp_line_id) > ";
            $tableData2 .= " <i class=\"fa fa-trash\"></i>";
            $tableData2 .= "  </button>";
            
            $tableData2 .= " </td>";
         
            $tableData2 .= "</tr>";
        }
    }

        $endTime='';
        $orderID =$request['orderID'];
        $startTime=Order::find($orderID);

    
        $result="";
        if($startTime!=null){
            $startTtime = $startTime->order_estimated_start_time;
            if(count($orderTasks)!=0){
                $endTime= gmdate('H:i:s', floor($taskTime * 3600));
                $secs = strtotime($endTime)-strtotime("00:00:00");
                $result .= date("H:i:s",strtotime($startTtime)+$secs);
                }
        }else{
            $startTtime = "08:30:00";
            if(count($orderTasks)!=0){
            $endTime= gmdate('H:i:s', floor($taskTime * 3600));
            $secs = strtotime($endTime)-strtotime("00:00:00");
            $result .= date("H:i:s",strtotime($startTtime)+$secs);
            }
        }
        

        return response()->json(['tableData2'=>$tableData2,'tableData'=>$tableData,'totalService'=>$totalService,'total'=>$total,'startTime'=>$startTime,'result'=>$result,'endTime'=>$endTime,'orderID'=>$orderID ]);
    }


    public function loadTempData(Request $request){

        $orderID=$request['orderID'];

        $orderDetail=Order::find($orderID);
        $vehicleNo=Vehicle::find($orderDetail->order_vehicle_id);
        $mobileNo=User::find($orderDetail->order_customer_id)->user_mobile_number;

        $orderItmDetails=OrderItem::where('order_item_order_id',$orderID)->get();
        $itemTotal=0;
        foreach( $orderItmDetails as  $orderItmDetail){

            $itemTotal+=$orderItmDetail->order_item_cost*$orderItmDetail->order_item_quantity;
            $saveItem=new JobItemDetailTemp();
            $saveItem->job_item_item_id=$orderItmDetail->order_item_item_id;
            $saveItem->job_item_temp_cost=$orderItmDetail->order_item_cost;
            $saveItem->job_item_temp_price=$orderItmDetail->order_item_price;
            $saveItem->job_item_temp_quantity=$orderItmDetail->order_item_quantity;
            $saveItem->job_item_user_id=Auth::user()->user_id;
            $saveItem->save();
        }

        $orderTaskDetails=OrderTask::where('order_task_order_id',$orderID)->get();

        $taskTotal=0;
        foreach( $orderTaskDetails as  $orderTaskDetail){

            $taskTotal+=$orderItmDetail->order_task_price*$orderItmDetail->order_task_duration;
           

            $saveTask=new JobTaskDetailTemp();
            $saveTask->job_task_task_id=$orderTaskDetail->order_task_task_id;
            $saveTask->job_task_temp_duration=$orderTaskDetail->order_task_duration;
            $saveTask->job_task_temp_cost=$orderTaskDetail->order_task_cost;
            $saveTask->job_task_temp_price=$orderTaskDetail->order_task_price;
            $saveTask->job_task_user_id=Auth::user()->user_id;
            $saveTask->save();
        }
      


        $total=$taskTotal+$itemTotal;
        return response()->json(['orderDetail'=>$orderDetail,'vehicleNo'=>$vehicleNo,'mobileNo'=>$mobileNo,'itemTotal'=>$itemTotal,'total'=>$total]);

    }

    public function deleteJobData(Request $request){

        $jobTasks=JobTaskDetailTemp::where('job_task_user_id',Auth::user()->user_id)->get();
        $jobItems=JobItemDetailTemp::where('job_item_user_id',Auth::user()->user_id)->get();

        foreach($jobTasks as $jobTask){
            $jobTask->delete();
        }
        foreach( $jobItems as  $jobItem){
            $jobItem->delete();
        }
    }

    public function getTaskByID(Request $request){

        $taskID=$request['taskID'];
        $getTask=Task::find($taskID);

        return response()->json($getTask);
    }

    public function getItemByID(Request $request){

        $itemID=$request['itemID'];
        $getItem=Item::find($itemID);

        return response()->json($getItem);
    }

    public function viewTaskById(Request $request){

        $taskID=$request['taskId'];
        $getTask=JobTaskDetailTemp::find($taskID);

        return response()->json($getTask);
    }


    public function viewItemById(Request $request){

        $itemId=$request['itemId'];
        $getItem=JobItemDetailTemp::find($itemId);

        return response()->json($getItem);
    }


    

    public function addItem(Request $request){


        $item=$request['item'];
        $qty=$request['qty'];

        $validator = \Validator::make($request->all(), [

            'item' => 'required',
            'qty' => 'required|not_in:0',
            
        ], [
            'item.required' => 'Task should be provided!',
            'qty.required' => 'Qty should be provided!',
            'qty.not_in' => 'Qty should be more than 0!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $itemDetail=Item::find($item);

            $save=new JobItemDetailTemp();
            $save->job_item_user_id=Auth::user()->user_id;
            $save->job_item_temp_cost=$itemDetail->item_unit_price*$qty;
            $save->job_item_temp_price=$itemDetail->item_unit_price;
            $save->job_item_temp_quantity=$qty;
            $save->job_item_item_id=$item;
            $save->save();
        
      
        return response()->json(['success'=>'Item saved successfully']);
    }

    public function addTask(Request $request){

        $task=$request['task'];

        $validator = \Validator::make($request->all(), [

            'task' => 'required'
        ], [
            'task.required' => 'Task should be provided!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $taskDetail=Task::find($task);

            $save=new JobTaskDetailTemp();
            $save->job_task_user_id=Auth::user()->user_id;
            $save->job_task_temp_cost=$taskDetail->task_price*$taskDetail->task_estimated_duration;
            $save->job_task_temp_price=$taskDetail->task_price;
            $save->job_task_temp_duration=$taskDetail->task_estimated_duration;
            $save->job_task_task_id=$task;
            $save->save();
        
      
        return response()->json(['success'=>'Task saved successfully']);
    }


    public function deleteTask(Request $request){

        $taskID=$request['taskID'];

        $deleteTask=JobTaskDetailTemp::find($taskID);
        if($deleteTask!=null){
            $deleteTask->delete();

            return response()->json(['success'=>'Task deleted successfully']);
        }
    }

    public function deleteOrderItem(Request $request){

        $itemID=$request['itemID'];

        $deleteItem=JobItemDetailTemp::find($itemID);
     
        if($deleteItem!=null){
            $deleteItem->delete();

            return response()->json(['success'=>'Item deleted successfully']);
        }
    }

    public function getCusDetail(Request $request){

        $CusID=$request['CusID'];
        $getCustomerDetail=Customer::find($CusID);
        $getVehicleDetail=Vehicle::where('vehicle_customer_id',$CusID)->first();

        return response()->json(['getCustomerDetail'=>$getCustomerDetail,'getVehicleDetail'=>$getVehicleDetail]);

    }

    public function store(Request $request){

        $systemDate = Carbon::now()->format('y/m/d');
        $jobStartTime=$request['jobStartTime'];
        $jobEndTime=$request['jobEndTime'];
        $orderID=$request['orderID'];


        $orderItmDetails=JobItemDetailTemp::where('job_item_user_id',Auth::user()->user_id)->get();
        $itemTotal=0;
        foreach( $orderItmDetails as  $orderItmDetail){

            $itemTotal+=$orderItmDetail->job_item_temp_price*$orderItmDetail->job_item_temp_quantity;
          
        }

        $orderTaskDetails=JobTaskDetailTemp::where('job_task_user_id',Auth::user()->user_id)->get();

        $taskTotal=0;
        foreach( $orderTaskDetails as  $orderTaskDetail){

            $taskTotal+=$orderTaskDetail->job_task_temp_price*$orderTaskDetail->job_task_temp_duration;
           

        }

        
        $saveJobCard=new JobCard();
        $saveJobCard->jobcard_code=01;
        $saveJobCard->jobcard_date=$systemDate;
        $saveJobCard->jobcard_start_time=$jobStartTime;
        $saveJobCard->jobcard_end_time=$jobEndTime;
        $saveJobCard->jobcard_duration=$request['duration'];
        $saveJobCard->jobcard_status=1;
        $saveJobCard->jobcard_advance_paid=0;
        $saveJobCard->jobcard_total= $taskTotal+ $itemTotal;
        $saveJobCard->jobcard_paid_amount=$taskTotal+ $itemTotal;
        $saveJobCard->jobcard_user_id=Auth::user()->user_id;
        $saveJobCard->jobcard_order_order_id=$orderID;
        $saveJobCard->save();

        $orderItmDetails=JobItemDetailTemp::where('job_item_user_id',Auth::user()->user_id)->get();
        
        foreach($orderItmDetails as  $orderItmDetail){
                $saveItem=new JobItemDetail();
                $saveItem->job_item_jobcard_id=$saveJobCard->jobcard_id;
                $saveItem->job_item_item_id=$orderItmDetail->job_item_item_id;
                $saveItem->job_item_cost=$orderItmDetail->job_item_temp_cost;
                $saveItem->job_item_price=$orderItmDetail->job_item_temp_price;
                $saveItem->job_item_quantity=$orderItmDetail->job_item_temp_quantity;
                $saveItem->save();

                $orderItmDetail->delete();
        }


        $orderTaskDetails=JobTaskDetailTemp::where('job_task_user_id',Auth::user()->user_id)->get();
 
        foreach($orderTaskDetails as  $orderTaskDetail){

                $saveItem=new JobTaskDetail();
                $saveItem->job_task_cost=$orderTaskDetail->job_task_temp_cost;
                $saveItem->job_task_price=$orderTaskDetail->job_task_temp_price;
                $saveItem->job_task_duration=$orderTaskDetail->job_task_temp_duration;
                $saveItem->job_task_jobcard_id=$saveJobCard->jobcard_id;
                $saveItem->job_task_task_id=$orderTaskDetail->job_task_task_id;
                $saveItem->save();

                $orderTaskDetail->delete();
        }

        $saveShedule=new JobSchedule();
        $saveShedule->job_schedule_date=$systemDate;
        $saveShedule->job_schedule_endtime=$request['end'];
        $saveShedule->job_schedule_jobcard_id=$saveJobCard->jobcard_id;
        $saveShedule->save();
      
        $orderUpdate=Order::find($orderID);
        $orderUpdate->order_status=2;
        $orderUpdate->save();

        return response()->json(['success'=>'Job saved successfully']);
    }


    public function getCurrentTime(){

    
    }
}