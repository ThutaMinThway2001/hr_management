<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
// use Cose\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AttendanceQrscanController extends Controller
{
    public function index()
    {
        return view('qr_scan');
    }

    public function store(Request $request)
    {
        if(!Hash::check(date('Y-m-d'), $request->qr_scan)){
            return [
                'status' => 'fail',
                'message' => 'QR code is incorrect.'
            ];
        }

        
        $user = auth()->user();

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
