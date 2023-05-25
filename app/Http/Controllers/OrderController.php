<?php


namespace App\Http\Controllers;

use App\Customer;
use App\Item;
use App\Order;
use App\OrderItem;
use App\OrderItemTemp;
use App\OrderTask;
use App\OrderTaskTemp;
use App\Refund;
use App\Shedule;
use App\Task;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function orderIndex()
    {

        $items = Item::where('item_status', 1)->get();
        $tasks = Task::where('task_status', 1)->get();
        $customers = Customer::where('customer_status', 1)->get();
        $vehicles = Vehicle::where('vehicle_status', 1)->get();

        return view('order', ['title' => 'Order', 'tasks' => $tasks, 'items' => $items, 'customers' => $customers, 'vehicles' => $vehicles]);
    }

    public function viewTableData()
    {

        $orderItem = OrderItemTemp::where('order_item_temp_user_id', Auth::user()->user_id)->latest()->get();

        $tableData = ""; //item
        $total = 0;

        $tableData2 = ""; //task
        $totalService = 0;

        if (count($orderItem) == 0) {
            $tableData .= "<tr>";
            $tableData .= "<td colspan='4' style='text-align:center'>" . 'Sorry No Results Found' . "</td>";
            $tableData .= "<tr>";
        } else {
            foreach ($orderItem as $order) {

                $total += $order->order_item_temp_price * $order->order_item_temp_quantity;
                $tableData .= "<tr>";  
                $tableData .= "<td>" . $order->Item->item_short_description . "</td>";
                $tableData .= "<td>" . $order->order_item_temp_quantity . "</td>";
                $tableData .= "<td>" . number_format($order->order_item_temp_price, 2) . "</td>";
                $tableData .= "<td>";
                $tableData .= "<button type='button'  class='btn btn-sm btn-basic  waves-effect waves-light'  data-target=\"#viewItemModal\" data-toggle=\"modal\"   data-id='$order->order_item_temp_line_id'   id='viewItem' > ";
                $tableData .= " <i class=\"fa fa-eye\"></i>";
                $tableData .= "  </button>";
                $tableData .= "&nbsp;";
                $tableData .= "<button type='button'  class='btn btn-sm btn-basic  waves-effect waves-light'  onclick=deleteItem($order->order_item_temp_line_id) > ";
                $tableData .= " <i class=\"fa fa-times\"></i>";
                $tableData .= "  </button>";
                $tableData .= " </td>";
                $tableData .= "</tr>";
            }
        }


        $orderTasks = OrderTaskTemp::where('order_task_temp_user_id', Auth::user()->user_id)->latest()->get();




        if (count($orderTasks) == 0) {
            $tableData2 .= "<tr>";
            $tableData2 .= "<td colspan='4' style='text-align:center'>" . 'Sorry No Results Found' . "</td>";
            $tableData2 .= "<tr>";
        } else {
            $taskTime = 0;
            foreach ($orderTasks as $order) {

                $taskTime += $order->order_task_temp_duration;
                $totalService += $order->order_task_temp_price * $order->order_task_temp_duration;
                $tableData2 .= "<tr>";
                $tableData2 .= "<td>" . $order->Task->task_short_description . "</td>";
                $tableData2 .= "<td>" . $order->order_task_temp_duration . "</td>";
                $tableData2 .= "<td>" . number_format($order->order_task_temp_price, 2) . "</td>";
                $tableData2 .= "<td>";

                $tableData2 .= "<button type='button'  class='btn btn-sm btn-basic  waves-effect waves-light'  data-target=\"#viewTaskModal\" data-toggle=\"modal\"   data-id='$order->order_task_temp_line_id'   id='viewTask' > ";
                $tableData2 .= " <i class=\"fa fa-eye\"></i>";
                $tableData2 .= "  </button>";
                $tableData2 .= "&nbsp;";
                $tableData2 .= "<button type='button'  class='btn btn-sm btn-basic  waves-effect waves-light'  onclick=deleteTask($order->order_task_temp_line_id) > ";
                $tableData2 .= " <i class=\"fa fa-trash\"></i>";
                $tableData2 .= "  </button>";

                $tableData2 .= " </td>";

                $tableData2 .= "</tr>";
            }
        }

        $endTime = '';
        $systemDate = Carbon::now()->format('y/m/d');
        $startTime = Shedule::where('schedule_date', $systemDate)->latest()->first(); 


        $result = "";
        if ($startTime != null) {
            $startTtime = $startTime->schedule_endtime;
            if (count($orderTasks) != 0) {
                $endTime = gmdate('H:i:s', floor($taskTime * 3600)); 
                $secs = strtotime($endTime) - strtotime("00:00:00"); 
                $result .= date("H:i:s", strtotime($startTtime) + $secs);
            }
        } else {
            $startTtime = "08:30:00";
            if (count($orderTasks) != 0) {
                $endTime = gmdate('H:i:s', floor($taskTime * 3600));
                $secs = strtotime($endTime) - strtotime("00:00:00");
                $result .= date("H:i:s", strtotime($startTtime) + $secs);
            }
        }


        return response()->json(['tableData2' => $tableData2, 'tableData' => $tableData, 'totalService' => $totalService, 'total' => $total, 'startTime' => $startTime, 'result' => $result, 'endTime' => $endTime]);
    }

    public function getTaskByID(Request $request)
    {

        $taskID = $request['taskID'];
        $getTask = Task::find($taskID);

        return response()->json($getTask);
    }

    public function getItemByID(Request $request)
    {

        $itemID = $request['itemID'];
        $getItem = Item::find($itemID);

        return response()->json($getItem);
    }

    public function viewTaskById(Request $request)
    {

        $taskID = $request['taskId'];
        $getTask = OrderTaskTemp::find($taskID);

        return response()->json($getTask);
    }


    public function viewItemById(Request $request)
    {

        $itemId = $request['itemId'];
        $getItem = OrderItemTemp::find($itemId);

        return response()->json($getItem);
    }


    public function addItem(Request $request)
    {


        $item = $request['item'];
        $qty = $request['qty'];

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

        $itemDetail = Item::find($item);

        $save = new OrderItemTemp();
        $save->order_item_temp_user_id = Auth::user()->user_id;
        $save->order_item_temp_cost = $itemDetail->item_unit_price * $qty;
        $save->order_item_temp_price = $itemDetail->item_unit_price;
        $save->order_item_temp_quantity = $qty;
        $save->order_item_temp_item_id = $item;
        $save->save();


        return response()->json(['success' => 'Item saved successfully']);
    }

    public function addTask(Request $request)
    {

        $task = $request['task'];

        $validator = \Validator::make($request->all(), [

            'task' => 'required'
        ], [
            'task.required' => 'Task should be provided!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $taskDetail = Task::find($task);

        $save = new OrderTaskTemp();
        $save->order_task_temp_user_id = Auth::user()->user_id;
        $save->order_task_temp_cost = $taskDetail->task_price * $taskDetail->task_estimated_duration;
        $save->order_task_temp_price = $taskDetail->task_price;
        $save->order_task_temp_duration = $taskDetail->task_estimated_duration;
        $save->order_task_temp_task_id = $task;
        $save->save();


        return response()->json(['success' => 'Task saved successfully']);
    }


    public function deleteTask(Request $request)
    {

        $taskID = $request['taskID'];

        $deleteTask = OrderTaskTemp::find($taskID);
        if ($deleteTask != null) {
            $deleteTask->delete();

            return response()->json(['success' => 'Task deleted successfully']);
        }
    }

    public function deleteOrderItem(Request $request)
    {

        $itemID = $request['itemID'];

        $deleteItem = OrderItemTemp::find($itemID);
        if ($deleteItem != null) {
            $deleteItem->delete();

            return response()->json(['success' => 'Item deleted successfully']);
        }
    }

    public function getCusDetail(Request $request)
    {

        $CusID = $request['CusID'];
        $getCustomerDetail = Customer::find($CusID);
        $getVehicleDetail = Vehicle::where('vehicle_customer_id', $CusID)->get();

        $options = "";
        $options .= "<option value='' selected disabled>" . 'Select Vehicle' . "</option>";
        foreach ($getVehicleDetail as $getVehicle) {
            $options .= "<option value='" . $getVehicle->vehicle_id . "'>" . $getVehicle->vehicle_registration_number . "</option>";
        }


        return response()->json(['getCustomerDetail' => $getCustomerDetail, 'options' => $options]);
    }

    public function requireRefundAmount(){
        $requireRefundAmount = Refund::latest()->first();

        return $requireRefundAmount;
    }

    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [

            'customer' => 'required',
            'vehicle' => 'required',

        ], [
            'customer.required' => 'Customer should be provided!',
            'vehicle.required' => 'Vehicle should be provided!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $systemDate = Carbon::now()->format('y/m/d');
        $startTime = Shedule::where('schedule_date', $systemDate)->latest()->first();

        $orderTasks = OrderTaskTemp::where('order_task_temp_user_id', Auth::user()->user_id)->latest()->get();
        $taskTime = 0;
        foreach ($orderTasks as $order) {

            $taskTime += $order->order_task_temp_duration;
        }
        $result = "";
        if ($startTime != null) {
            $startTime = $startTime->schedule_endtime;
            $endTime = gmdate('H:i:s', floor($taskTime * 3600));
            $secs = strtotime($endTime) - strtotime("00:00:00");
            $result .= date("H:i:s", strtotime($startTime) + $secs);
        } else {
            $startTime = "08:30:00";
            $endTime = gmdate('H:i:s', floor($taskTime * 3600));
            $secs = strtotime($endTime) - strtotime("00:00:00");
            $result .= date("H:i:s", strtotime($startTime) + $secs);
        }


        $systemDate = Carbon::now()->format('y/m/d');

        $orderItem = OrderItemTemp::where('order_item_temp_user_id', Auth::user()->user_id)->latest()->get();
        $total = 0;
        foreach ($orderItem as $order) {
            $total += $order->order_item_temp_price * $order->order_item_temp_quantity;
        }

        $totalService = 0;
        $orderTasks = OrderTaskTemp::where('order_task_temp_user_id', Auth::user()->user_id)->latest()->get();
        foreach ($orderTasks as $order) {
            $totalService += $order->order_task_temp_price * $order->order_task_temp_duration;
        }

        $totalCost = $totalService + $total;

        $save = new Order();
        $save->order_date = $systemDate;
        $save->order_estimated_start_time = $startTime;
        $save->order_estimated_end_time = $result;
        $save->order_estimated_duration = $endTime;
        $save->order_total_amount = $totalCost;
        $save->order_status = 1;
        $save->order_require_refund = $request['requireRefund'];
        $save->order_customer_id = $request['customer'];
        $save->order_vehicle_id = $request['vehicle'];

        $refoundAmount = Refund::latest()->first();
        if ($request['requireRefund'] == 1) {
            $save->order_require_refund_amount = $refoundAmount->refund_amount;
        } else {
            $save->order_require_refund_amount = 0;
        }

        $save->save();

        $updateOrderId = Order::find($save->order_id);
        $updateOrderId->order_code = 'JO-' . $save->order_id;
        $updateOrderId->save();
        $saveShedule = new Shedule();
        $saveShedule->schedule_endtime = $result;
        $saveShedule->schedule_order_id = $save->order_id;
        $saveShedule->schedule_date = $systemDate;
        $saveShedule->save();

        $orderTasks = OrderTaskTemp::where('order_task_temp_user_id', Auth::user()->user_id)->get();

        foreach ($orderTasks as $orderTask) {

            $taskPurCost = Task::find($orderTask->order_task_temp_task_id);

            $saveTask = new OrderTask();
            $saveTask->order_task_order_id = $save->order_id;
            $saveTask->order_task_task_id = $orderTask->order_task_temp_task_id;
            $saveTask->order_task_cost = $orderTask->order_task_temp_cost;
            $saveTask->order_task_price = $orderTask->order_task_temp_price;
            $saveTask->order_task_duration = $orderTask->order_task_temp_duration;
            $saveTask->order_task_purchase_cost = $taskPurCost->task_cost;
            $saveTask->save();

            $orderTask->delete();
        }


        $orderItem = OrderItemTemp::where('order_item_temp_user_id', Auth::user()->user_id)->get();


        foreach ($orderItem as $order) {
            $saveItem = new OrderItem();
            $saveItem->order_item_order_id = $save->order_id;
            $saveItem->order_item_item_id = $order->order_item_temp_item_id;
            $saveItem->order_item_cost = $order->order_item_temp_cost;
            $saveItem->order_item_price = $order->order_item_temp_price;
            $saveItem->order_item_quantity = $order->order_item_temp_quantity;
            $saveItem->save();

            $order->delete();
        }


        return response()->json(['success' => 'Order saved successfully']);
    }



    // public function getFutureDateStartTime(Request $request)
    // {

    //     $date = date('Y-m-d', strtotime($request['date']));
    //     $systemDate = date('Y-m-d', strtotime(Carbon::now()));
    //     $orderTasks = OrderTask::whereDate('created_at', '=', $date)->latest()->get();

    //     $taskTime = 0;
    //     foreach ($orderTasks as $order) {

    //         $taskTime += $order->order_task_duration;
    //     }
    //     if ($date != $systemDate) {
    //         $endTime = '';


    //         $startTime = Shedule::where('schedule_date', $date)->latest()->first(); //last one first


    //         $result = "";
    //         if ($startTime != null) {
    //             $startTtime = $startTime->schedule_endtime;
    //             if (count($orderTasks) != 0) {
    //                 $endTime = gmdate('H:i:s', floor($taskTime * 3600)); //floor returs floating point number
    //                 $secs = strtotime($endTime) - strtotime("00:00:00"); //strtotime converts to time
    //                 $result .= date("H:i:s", strtotime($startTtime) + $secs);
    //             }
    //         } else {
    //             $startTtime = "08:30:00";
    //             if (count($orderTasks) != 0) {
    //                 $endTime = gmdate('H:i:s', floor($taskTime * 3600));
    //                 $secs = strtotime($endTime) - strtotime("00:00:00");
    //                 $result .= date("H:i:s", strtotime($startTtime) + $secs);
    //             }
    //             return response()->json([ 'startTime' => $startTime, 'result' => $result, 'endTime' => $endTime]);
 
    //         }
           
    //     }

       
    // }
}
