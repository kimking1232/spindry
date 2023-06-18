<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // pencarian index/view
        $q = $request->q;
        if($q)
        {
            $promotions = Promotion::where('title', 'like', '%'.$q.'%')->paginate(100);
        }else {
            // menampilkan seluruh data index/view
            $promotions = Promotion::paginate(100);
        }
        //vardump cek data didalam tabel database
        // return $promotions;
        return view('pages.promotion', compact('promotions', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.promotion-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'title' => 'required|min:5|max:50',
            'discount' => 'required|numeric',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
            'title.required' => 'Kolom TITLE Tidak Boleh Kosong !',
            'title.min' => 'kolom TITLE tertalu pendek !',
            'title.max' => 'kolom TITLE tertalu panjang !',
            'discount.required' => 'Kolom DISCOUNT Tidak Boleh Kosong !',
            'discount.numeric' => 'kolom DISCOUNT harus angka !',
            'picture.required' => 'Kolom PICTURE Tidak Boleh Kosong !',
            'picture.image' => 'Kolom PICTURE harus format jpeg, png, jpg, gif, svg !',
            'picture.max' => 'File pada Kolom PICTURE terlalu besar maksimal 2MB !',
        ]
    );

        $picture = $request->file('picture');
        $filename = time() . '-' . rand() . '-' . $picture->getClientOriginalName(); //untuk insert file picture
        $picture->move(public_path('/img/promotions/'), $filename); // kedalam folder public/img/heroes (sesuaikan dgn folder anda masing2)

        $status = $request->has('status') ? 'show' : 'hide';

        Promotion::create([
            'title' => $request->title,
            'discount' => $request->discount,
            'picture' => $filename,
            'status' => $status,
        ]);
        return redirect('/promotion');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        // return $promotion;
        return view('pages.promotion-edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        // return $request;
        $request->validate(
            [
            'title' => 'required|min:5|max:30',
            'discount' => 'required|numeric',
            // 'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],
        [
            'title.required' => 'Kolom TITLE Tidak Boleh Kosong !',
            'title.min' => 'kolom TITLE tertalu pendek !',
            'title.max' => 'kolom TITLE tertalu panjang !',
            'discount.required' => 'Kolom DISCOUNT Tidak Boleh Kosong !',
            'discount.numeric' => 'kolom DISCOUNT harus angka !',
            // 'picture.required' => 'Kolom PICTURE Tidak Boleh Kosong !',
            // 'picture.image' => 'Kolom PICTURE harus format jpeg, png, jpg, gif, svg !',
            // 'picture.max' => 'File pada Kolom PICTURE terlalu besar maksimal 2MB !',
        ]
    );

        $status = $request->has('status') ? 'show' : 'hide';
        if ($request->has('picture')) {
            unlink(public_path('/img/promotions/' . $promotion->picture));
            $picture = $request->file('picture');
            $filename = time() . '-' . rand() . '-' . $picture->getClientOriginalName();
            $picture->move(public_path('/img/promotions/'), $filename);

            Promotion::where('id', $promotion->id)->update([
                'title' => $request->title,
                'discount' => $request->discount,
                'picture' => $filename,
                'status' => $status,
            ]);
        } else {
            Promotion::where('id', $promotion->id)->update([
                'title' => $request->title,
                'discount' => $request->discount,
                'status' => $status,
            ]);
        }

        return redirect('/promotion');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        if (file_exists(asset('img/promotions/'.$promotion->picture))) {
            unlink(public_path('/img/promotions/' . $promotion->picture));
        }
        Promotion::destroy('id', $promotion->id);
        // Promotion::where('id', $promotion->id)->delete();
        return redirect('/promotion');
    }
}
