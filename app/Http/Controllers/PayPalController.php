<?php
  
namespace App\Http\Controllers;

use App\Advance;
use App\JobCard;
use App\Order;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
   
class PayPalController extends Controller
{
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function advancePayment()
    {

        $advancePercentage=Advance::latest()->first();
        $orderDetail=Order::latest()->first(); 
        $totalAmount=$orderDetail->order_require_refund_amount+$orderDetail->order_total_amount;
        $amount=$totalAmount/100;
        $advancePrice=number_format($amount*$advancePercentage->advance_percentage, 2);

        $price=number_format($advancePrice, 2);

//*
        $data = [];
        $data['items'] = [
            [
                'name' => 'advancepayment',
                'price' => $price,
                'desc'  => 'order advance payment',
                'qty' => 1
            ]
        ];
  
        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success'); 
        $data['cancel_url'] = route('payment.cancel'); 
        $data['total'] = $price;
  
        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
  
        return redirect($response['paypal_link']);
    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Your payment is canceled');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
           
           //edited
            $advancePercentage=Advance::latest()->first();
            $orderDetail=Order::latest()->first();
            $totalAmount=$orderDetail->order_require_refund_amount+$orderDetail->order_total_amount;
            $amount=$totalAmount/100;

            $advancePrice=number_format($amount*$advancePercentage->advance_percentage, 2);

            $orderDetail=Order::latest()->first();
            $orderDetail->order_advance_payment=$advancePrice;
            $orderDetail->order_balance_amount=number_format($totalAmount-$advancePrice, 2);
            $orderDetail->save();
          //edited
             return redirect()->route('order')->with('success', 'Advance Payment processed successfully!');

        }
  
        dd('Something is wrong.');
    }




    public function balancePayment(Request $request)
    {

        $idOrder=$request['idOrder'];

        $orderId=JobCard::find($idOrder);
        $orderBalance=Order::find($orderId->order_order_id);
      
        $data = [];
        $data['items'] = [
            [
                'name' => 'balance',
                'price' => $orderBalance->order_balance_amount,
                'desc'  => 'Job card balance',
            
            ]
        ];
  
        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('balance.success', ['idOrder' => $idOrder]);
       

        $data['cancel_url'] = route('balance.cancel');
        $data['total'] = $orderBalance->order_balance_amount;
  
        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
  
        return redirect($response['paypal_link']);
    }
   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelBalance()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */

    public function successBalance(Request $request)
    {
        $idOrder=$request['idOrder'];
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

            $orderId=JobCard::find($idOrder);

            $orderDetail=Order::find($orderId->order_order_id);
    
            $updateJobCard=JobCard::find($idOrder);
            $updateJobCard->jobcard_paid_amount=$orderDetail->order_balance_amount;
            $updateJobCard->jobcard_status=2;
            $updateJobCard->update();
    
            $orderBalanceUpdate=Order::find($orderId->order_order_id);
            $orderBalanceUpdate->order_balance_amount=0;
            $orderBalanceUpdate->update();

          return redirect()->route('job-payment')->with('success', 'Advance Payment processed successfully!');
        }
  
        dd('Something is wrong.');
    }

}