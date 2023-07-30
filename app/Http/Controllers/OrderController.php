<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $q = $request->q;
        $pagination = $request->has('pagination') ? $request->pagination:10;
        if($q)
        {
            $orders = Order::where('user', 'like', '%'.$q.'%')->paginate($pagination);
        } else {
            // menampilkan seluruh data index/view
            // $heroes = Hero::all();
            // menampilkan pagination data index/view
            $orders = Order::paginate($pagination);

        }
        //vardump cek data didalam tabel database
        // return $heroes;
        return view('pages.order', compact('orders', 'q'));
    }

    public function status(Order $order)
    {
        if($order->status == 'notYet')
        {
            Order::where('id', $order->id)->update([
                'status' => 'finish'
            ]);
            return redirect()->back()->with('succes', 'status order no '.$order->number. 'berhasil di update');
        }else{
            return redirect()->back()->with('succes', 'status order no '.$order->number. 'telah selesai');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
