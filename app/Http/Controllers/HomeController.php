<?php


namespace App\Http\Controllers;

use App\JobCard;
use App\Order;
use App\Customer;
use App\User;
use Illuminate\Http\Request;

Class HomeController extends Controller{

    public function index(){


        $completedJobs = JobCard::whereDate('jobcard_date','=',date('Y-m-d'))->count('jobcard_id');
        $newJobs = Order::whereDate('order_date','=',date('Y-m-d'))->count('order_id');
        $newCustomers = Customer::whereDate('created_at','=',date('Y-m-d'))->count('customer_id');
        $latestJobs = JobCard::join('order', 'order.order_id', '=', 'jobcard.order_order_id')
          ->join('customer', 'customer.customer_id', '=', 'order.order_customer_id')
          ->orderBy('JobCard.created_at','desc')->take(6)->get(['jobcard.jobcard_id','jobcard.jobcard_date','jobcard.jobcard_paid_amount','jobcard.jobcard_status', 'customer.customer_firstname']);;
        //dd($latestJobs);

        return view('index', ['title' => 'Dashboard','completedJobs'=>$completedJobs,'newJobs'=>$newJobs,'newCustomers'=>$newCustomers,'latestJobs'=>$latestJobs]);
        
    }

    public function incomeChart(){

        $incomeChart = Jobcard::all();

        return  $incomeChart;
        

    }
    
}

