<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckinCheckoutController extends Controller
{
    public function checkInCheckOut(){
        $hashValue = Hash::make(date('Y-m-d'));
        return view('checkin_checkout', compact('hashValue'));
    }

    public function checkInCheckOutStore(Request $request){
    
        // return $request->pin_code;
        $user = User::where('pin_code', $request->pin_code)->first();

        if(!$user){
            return [
                'status' => 'fail',
                'message' => 'Pin code is wrong'
            ];
        }

        $checkin_checkout_data = CheckinCheckout::firstOrCreate(
            [
                'user_id' => $user->id,
                'date' => now()->format('Y-m-d')
            ]
        );

        if(!is_null($checkin_checkout_data->checkin_time) && !is_null($checkin_checkout_data->checkout_time)){
            return [
                'status' => 'fail',
                'message' => 'Alread checkin and checkout for today'
            ];
        }

        if(is_null($checkin_checkout_data->checkin_time))
        {
            $checkin_checkout_data->checkin_time = now();
            $message = 'Successfully Checkin at '. now();
        }
        else
        {
            if(is_null($checkin_checkout_data->checkout_time))
            {
                $checkin_checkout_data->checkout_time = now();
                $message = 'Successfully Checkout at '. now();
            }
        }

        $checkin_checkout_data->update();

        return [
            'status' => 'success',
            'message' => $message
        ];
    }
}
