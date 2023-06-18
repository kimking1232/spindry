<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request-> q;
        $pagination = $request->has('pagination') ? $request->pagination:10;
        if($q)
        {
            $partners = Partner::where('title', 'like', '%'.$q.'%')->paginate($pagination);
        } else {
            $partners = Partner::paginate($pagination);
        }
        return view('pages.partner', compact('partners', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.partner-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate(
            [
                'title' => 'required|min:5|max:10',
                'logo' => 'required|image|mimes:jpg,jpng,png,gif,svg|max:2048'
            ],
            [
                'title.required' => 'Kolom TITLE Tidak Boleh Kosong !',
                'title.min' => 'Kolom TITLE Terlalu Pendek !',
                'title.max' => 'Kolom TITLE Terlalu panjang !',
                'logo.required' => 'Kolom LOGO Tidak Boleh Kosong !',
                'logo.img' => 'Kolom LOGO Harus Format jpeg, png, jpg, gif, svg !',
                'logo.max' => 'File Pada kolom LOGO Terlalu Besar Maksimal 2MB !'
            ],
        );

        $logo = $request->file('logo');
        $filename = time().'-'.rand().'-'.$logo->getClientOriginalName();
        $logo->move(public_path('/img/partners/'), $filename);

        $status = $request->has('status')? 'show' : 'hide';

        Partner::create([
            'title' => $request->title,
            'logo' => $filename,
            'status' => $status,
        ]);

        return redirect('/partner')->with('success', $request->title, 'Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        return view('pages.partner-edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $request->validate(
            [
                'title' => 'required|min:5|max:10',
                // 'logo' => 'required|image|mimes:jpg,jpng,png,gif,svg|max:2048'
            ],
            [
                'title.required' => 'Kolom TITLE Tidak Boleh Kosong !',
                'title.min' => 'Kolom TITLE Terlalu Pendek !',
                'title.max' => 'Kolom TITLE Terlalu panjang !',
                // 'logo.required' => 'Kolom LOGO Tidak Boleh Kosong !',
                // 'logo.img' => 'Kolom LOGO Harus Format jpeg, png, jpg, gif, svg !',
                // 'logo.max' => 'File Pada kolom LOGO Terlalu Besar Maksimal 2MB !'
            ],
        );

        $status = $request->has('status')? 'show' : 'hide';

        if($request->has('logo'))
        {
            unlink(public_path('/img/partners'.$partner->logo));
            $logo = $request->file('logo');
            $filename = time().'-'.rand().'-'.$logo->getClientOriginalName();
            $logo->move(public_path('/img/partners/'), $filename);

            Partner::where('id', $partner->id)->update([
                'title' => $request->title,
                'logo' => $filename,
                'status' => $status
            ]);
        }else{
            Partner::where('id', $partner->id)->update([
                'title' => $request->title,
                'status' => $status,
            ]);
        }
        return redirect('/partner');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        if(file_exists(public_path('/img/partners/'.$partner->logo))){
            unlink(public_path('/img/partners/'.$partner->logo));
        }
        Partner::destroy('id', $partner->id);
        return redirect('/partner');
    }
}
