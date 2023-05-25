<?php


namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Vehicle;
use App\Order;
use App\JobCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\JobTaskDetail;
use Illuminate\Support\Facades\Auth;


class ReportsController extends Controller
{
    public function reports(){

        return view('reports',['title'=>'Reports']);
    }
    
    
    public function serviceHistory(Request $request ){
            
        $customer = $request['customer'];
        $fromDate = $request['fromDate'];
        $toDate = $request['toDate'];
        
         $jobList = JobCard::join('order', 'order.order_id', '=', 'jobcard.order_order_id')
         ->join('vehicle', 'vehicle.vehicle_id', '=', 'order.order_vehicle_id')
         ->join('customer', 'customer.customer_id', '=', 'order.order_customer_id')
         ->get(['jobcard.*', 'customer.*', 'vehicle.*']);
        
         if (!empty($customer)) {
    
            $jobList = $jobList->where('customer_id', $customer);
        }
        
        if (!empty($fromDate)) {
    
            $jobList = $jobList->where('jobcard_date', '>=', $fromDate);
        }
        
        if (!empty($toDate)) {
    
            $jobList = $jobList->where('jobcard_date', '<=', $toDate);
        }

        $jobList = $jobList->where('jobcard_status',2 || 1 );

        $customers=Customer::where('customer_status',1)->get();

          return view('reports/serviceHistory',['title'=>'Service History', 'customers'=>$customers, 'joblist'=>$jobList]);
          
    }
   
    
    public function completedJobs(Request $request){

        $fromDate = $request['fromDate'];
        $toDate = $request['toDate'];

        $jobList = JobCard::join('order', 'order.order_id', '=', 'jobcard.order_order_id')
         ->join('vehicle', 'vehicle.vehicle_id', '=', 'order.order_vehicle_id')
         ->join('customer', 'customer.customer_id', '=', 'order.order_customer_id')
         ->get(['jobcard.*', 'customer.*', 'vehicle.*']);

         if (!empty($fromDate)) {
    
            $jobList = $jobList->where('jobcard_date', '>=', $fromDate);
        }
        
        if (!empty($toDate)) {
    
            $jobList = $jobList->where('jobcard_date', '<=', $toDate);
        }

        $jobList = $jobList->where('jobcard_status',1 || 2);


            return view('reports/completedJobs',['title'=>'Completed Jobs', 'joblist'=>$jobList]);
    }

    
    
    public function jobEfficiency(Request $request){

        $fromDate = $request['fromDate'];
        $toDate = $request['toDate'];       

        $jobList = JobCard::join('order', 'order.order_id', '=', 'jobcard.order_order_id')
         ->join('vehicle', 'vehicle.vehicle_id', '=', 'order.order_vehicle_id')
         ->join('customer', 'customer.customer_id', '=', 'order.order_customer_id')
         ->get(['jobcard.*', 'vehicle.*', 'order.*']);

         if (!empty($fromDate)) {
    
            $jobList = $jobList->where('jobcard_date', '>=', $fromDate);
        }
        
        
        if (!empty($toDate)) {
    
            $jobList = $jobList->where('jobcard_date', '<=', $toDate);
        }


        $jobList = $jobList->where('jobcard_status',1 || 2);

        $jobList->map(function ($value)  {
                $jobtime = Carbon::parse($value['jobcard_duration']);
                $ordertime = Carbon::parse($value['order_estimated_duration']);

                $difference = $jobtime->diffInSeconds($ordertime);
           
            return $value['duration'] = gmdate('H:i:s', $difference);
        });


            return view('reports/jobEfficiency',['title'=>'Job Efficiency','joblist'=>$jobList ]);
    }


    public function revenue(Request $request){

        $fromDate = $request['fromDate'];
        $toDate = $request['toDate'];       

        $jobTaskList = JobCard::join('job_task_detail', 'job_task_detail.job_task_jobcard_id', '=', 'jobcard.jobcard_id')
        //->get(['jobcard.*', 'job_task_detail.*']);
         ->join('order', 'order.order_id', '=', 'jobcard.order_order_id')
         //->join('customer', 'customer.customer_id', '=', 'order.order_customer_id')
         ->get(['jobcard.*', 'job_task_detail.*', 'order.*']);

        

         if (!empty($fromDate)) {
    
            $jobTaskList = $jobTaskList->where('jobcard_date', '>=', $fromDate);
        }
        
        
        if (!empty($toDate)) {
    
            $jobTaskList = $jobTaskList->where('jobcard_date', '<=', $toDate);
        }

       // $jobTaskList = $jobTaskList->groupBy('job_task_jobcard_id')->sum('job_task_cost');

        //dd($jobTaskList);
        
        //$jobTaskList->groupby('job_task_jobcard_id');
        
        
        
        //  $num = $mystuff->groupBy('dateDay')->map(function ($row) {
        //      return $row->sum('n');
        //  });

        // $jobTaskList = $jobTaskList->groupBy('job_task_jobcard_id')->map(function ($jobcost) {
        //$jobTaskList = $jobTaskList->groupBy('job_task_jobcard_id');
        
        // $jobTaskList->map(function ($jobcost) {

        //     return $jobcost->sum('job_task_cost');
        // });

        // $jobTaskList->map(function ($jobprice) {
        //     return $jobprice->sum('job_task_cost');
        // });
        
        //dd($jobTaskList);
        
            return view('reports/revenue',['title'=>'Job Revenue','jobTaskList'=>$jobTaskList ]);
    }


    public function inventoryConsumed(){

            return view('reports/inventory-consumed',['title'=>'Inventory Consumed']);
    }



    public function vehicleList(Request $request){

        $customer = $request['customer'];

        $query = Vehicle::query();

        if (!empty($customer)) {
    
            $query = $query->where('vehicle_customer_id', $customer);
        }

        $vehicleList = $query->where('vehicle_status',1)->get();

        $customers=Customer::where('customer_status',1)->get();

            return view('reports/vehicleList',['title'=>'Vehicle List', 'customers'=>$customers, 'vehicleList'=>$vehicleList ]);
    }


    public function viewCustomerName(Request $request){
        $customerID = $request['customerID'];
        $getCustomerName=Customer::find($customerID);
            return $getCustomerName;
    }
}