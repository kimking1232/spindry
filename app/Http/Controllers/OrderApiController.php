<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Promotion;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $orders = Order::where('user_id', $user_id)
        ->where('status','notYet')
        ->with(['promotion', 'service'])
        ->get()
        ->last();
        $data = [
            'status' => 'success',
            'message' => 'Berikut data order',
            'data' => $orders
        ];

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(), [
                // 'user_id' => 'required',
                'service_id' => 'required',
                'weight' => 'required|numeric',
                'date' => 'required',
            ],
            [
                'service_id,required' => 'Slahkan pilih layanan!',
                'weight.required' => 'Jangan lupa masukan berat pakaian!',
                'weight.numeric' => 'Berat pakaian menggunakan angka',
                'date.required' => 'Pilih waktu pencucian',
            ]
        );

        if($validator->fails())
        {
            return response()->json(
                [
                    'status' => 'error',
                    'message'=> $validator->errors()
                ]
            );
        }

        $promo = Promotion::where('id', $request->promo_id)->first();
        $discount = $promo ? $promo->discount : 0;
        $service = Service::where('id', $request->service_id)->first();
        $total_price = ($request->weight * $service->price) * (100 - $discount)/100;
        $number = time().'-'.rand();

        $order = Order::create([
            'number' => $number,
            'user_id' => Auth::user()->id,
            'service_id' => $request->service_id,
            'promo_id' => $promo ? $request->promo_id : NULL,
            'weight' => $request->weight,
            'date' => $request->date,
            'total_price' => $total_price,
        ]);

        $data = [
            'status' => 'success',
            'message' => 'Data order berhasil ditambahkan',
            'data' => $order
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        Order::destroy($order->id);
        $data = [
            'status' => 'success',
            'message' => 'Data order berhasil dihapuskan',
            'data' => $order
        ];

        return response()->json($data);
    }
}
