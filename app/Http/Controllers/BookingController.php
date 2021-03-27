<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB ;
use App\BookingModel;
use App\PaymentModel;
use App\PaymentModesModel;
use App\PaymentLinkModel;
use App\PaymentModeDetailsModel;
use App\PaymentForPurposeModel;

class BookingController extends Controller
{
  //this function is for test 
  public function getPaymentsByBooking(Request $request){

    $booing = new BookingModel();

    $booking_id = $booing->booking_id = $request->input('booking_id');

    if(is_null($booking_id)){
      return response()->json([$response = 'success'=>0, 'message'=>"Booking Id Required"]);
    }
    elseif($booing::where('booking_id','=',$booking_id)->first()){      
      $data = $booing::where('booking_id','=',$booking_id)->get([
        'payment_id',
        'payment_id_2',
        'payment_id_3',
        'payment_id_4',
        'payment_id_5',
        'sales_person_id',
        'lead_id'
      ]);

      $payments = new PaymentModel();
      $payArray = [];
      foreach($data as  $key=>$value){

        $payArray = $payments::where('payment_id','=',$value->payment_id)
                                          ->orWhere('payment_id','=',$value->payment_id_2)
                                          ->orWhere('payment_id','=',$value->payment_id_3)
                                          ->orWhere('payment_id','=',$value->payment_id_4)
                                          ->orWhere('payment_id','=',$value->payment_id_5)
                                          ->get(['payment_id','payment_mode_id','payment_for_purpose_id']); 
        
      }
      foreach($payArray as $key=>$values){
        
       $values->paymentDetails = DB::table('payment_master')
                       ->join('payment_mode_details','payment_mode_details.payment_id','payment_master.payment_id')
                       ->join('payment_for_purpose','payment_for_purpose.payment_for_purpose_id','=','payment_master.payment_for_purpose_id')
                       ->join('booking_master','booking_master.payment_id','=','payment_master.payment_id')
                       ->join('payment_modes','payment_modes.payment_mode_id','=','payment_master.payment_mode_id')
                       ->select('payment_master.created_at','payment_modes.payment_mode','payment_master.amount','payment_mode_details.payment_mode_details_title',
                                  'payment_mode_details.payment_mode_details_description',
                                  'payment_mode_details.payment_details_id','payment_modes.payment_mode_id',
                                  'payment_for_purpose.payment_for_title','booking_master.remark')          
                       ->where('payment_mode_details.payment_id','=',$values->payment_id)
                       ->where('payment_modes.payment_mode_id','=',$values->payment_mode_id)
                       ->where('payment_for_purpose.payment_for_purpose_id','=',$values->payment_for_purpose_id)
                       ->where('booking_master.payment_id','=',$values->payment_id)
                       ->orWhere('booking_master.payment_id_2','=',$values->payment_id)
                       ->orWhere('booking_master.payment_id_3','=',$values->payment_id)
                       ->orWhere('booking_master.payment_id_4','=',$values->payment_id)
                       ->orWhere('booking_master.payment_id_5','=',$values->payment_id)
                       ->get();

      }
     return response()->json([$response = 'success'=>1 , "data"=>$payArray]);

    }
    else{
     
      return response()->json([$response = 'success'=>0 , 'message'=>'This is not valid booking id']);
    }

  }

  public function editPaymentDetails(Request $request){

    $paymentMaster = new PaymentModel();
    $bookingMaster = new BookingModel();
    $modeDetail = new PaymentModeDetailsModel();
    $purposeDetail = new PaymentForPurposeModel();

    $payment_id = $paymentMaster->payment_id = $request->input('payment_id');
    $payment_mode_id = $paymentMaster->payment_mode_id = $request->input('payment_mode_id');
    $amount = $paymentMaster->amount = $request->input('amount');
    $remark = $bookingMaster->remark = $request->input('remark');
    $payment_mode_details_title = $modeDetail->payment_mode_details_title = $request->input('payment_mode_details_title');
    $payment_mode_details_description = $modeDetail->payment_mode_details_description = $request->input('payment_mode_details_description');
    $payment_for_purpose_id = $purposeDetail->payment_for_purpose_id = $request->input('payment_for_purpose_id');
    $payment_details_id = $modeDetail->payment_details_id = $request->input('payment_details_id');


    if(is_null($payment_id)){
      return response()->json([$response = 'success' => 0 , 'message' => 'Payment id is required']);
    }
    if(is_null($payment_mode_id)){
      return response()->json([$response = 'success'=>0 , 'message'=>'Payment mode is required']);
    }
    if($paymentMaster::where('payment_id','=',$payment_id)->where('payment_mode_id','=',$payment_mode_id) ->first()){

      //when payment mode is not changed    
    
        $updateDetails = DB::update('update payment_mode_details set payment_mode_details_title = ? , payment_mode_details_description = ?
                                      where payment_id = ? and payment_details_id = ?',[$payment_mode_details_title,
                                                                                        $payment_mode_details_description,$payment_id,
                                                                                        $payment_details_id]);

       $update = DB::update('update payment_master set amount = ? where  payment_id = ?',[$amount,$payment_id]);
       if($updateDetails || $update){
         echo "Data updated";
         return response()->json([$response = 'success'=>1 , 'message'=>'Data updated']);
       }                     
       else{
         return response()->json([$response = 'success'=>0 , 'message'=>'Data not updated']);
       }                   

    }
    else{
      //if mode id changed payment_id
     
      if(is_null($payment_details_id)){
        return response()->json([$response = 'success'=>0, 'message'=>'payment details id required']);
      }
      else{

        if($payment_mode_id!=0){
            $update = DB::update('update payment_master set amount = ?, payment_mode_id = ? where payment_id = ?',[$amount,$payment_mode_id,$payment_id]);
              if($update){
                 $updatePaymentMode = DB::update('update payment_mode_details set payment_mode_details_title = ? , payment_mode_details_description = ?
                                              where payment_id = ? and payment_details_id = ?',[$payment_mode_details_title,$payment_mode_details_description,$payment_id,$payment_details_id]);
           
                 if($updatePaymentMode){
                   return response()->json([$response = 'success'=>1, 'message'=>'Data Update Successfully']);
                 }
                 else{
                   return response()->json([$response = 'success'=> 0, 'message'=>'Data payment mode not updated']);
                 }
              } 
              else{
                return response()->json([$response = 'success'=>0 , 'message'=>'Data not update']);
              }
         }
         else{
           return response()->json([$response = 'success'=>0 ,'message'=>'ID id 0']); 
         }

      }

    }
  }
  public function getData(Request $request){
    $booing = new BookingModel();

    $booking_id = $booing->booking_id = $request->input('booking_id');

    if(is_null($booking_id)){
      return response()->json([$response = 'success'=>0, 'message'=>"Booking Id Required"]);
    }
    elseif($booing::where('booking_id','=',$booking_id)->first()){      
      $data = $booing::where('booking_id','=',$booking_id)->get([
        'payment_id',
        'payment_id_2',
        'payment_id_3',
        'payment_id_4',
        'payment_id_5',
        'sales_person_id',
        'lead_id'
      ]);

      $payments = new PaymentModel();
      $payArray = [];
      foreach($data as  $key=>$value){

        $payArray = $payments::where('payment_id','=',$value->payment_id)
                                          ->orWhere('payment_id','=',$value->payment_id_2)
                                          ->orWhere('payment_id','=',$value->payment_id_3)
                                          ->orWhere('payment_id','=',$value->payment_id_4)
                                          ->orWhere('payment_id','=',$value->payment_id_5)
                                          ->get(['payment_id','payment_mode_id','payment_for_purpose_id','amount']); 
        
      }
      foreach($payArray as $key=>$values){

        $values->paymentDetails = DB::table('payment_modes')
                              ->join('payment_master','payment_master.payment_mode_id','payment_modes.payment_mode_id')
                              ->join('payment_mode_details','payment_mode_details.payment_id','payment_master.payment_id')
                              ->join('payment_for_purpose','payment_for_purpose.payment_for_purpose_id','payment_master.payment_for_purpose_id')
                              ->leftJoin('booking_master','booking_master.payment_id','payment_master.payment_id')
                              ->where('payment_modes.payment_mode_id','=',$values->payment_mode_id)
                              ->where('payment_mode_details.payment_id','=',$values->payment_id)
                              ->where('payment_for_purpose.payment_for_purpose_id','=',$values->payment_for_purpose_id)
                              ->select('payment_modes.payment_mode','payment_mode_details.payment_mode_details_title',
                                         'payment_mode_details.payment_mode_details_description',
                                         'payment_mode_details.payment_details_id','payment_for_purpose.payment_for_title',
                                         'booking_master.remark')
                              ->get();

      }
     return response()->json([$response = 'success'=>1 , "data"=>$payArray]);
    }
    else{
      return response()->json([$response = 'success'=>0 , 'message'=>'This is not valid booking id']);
    }
  }
}
