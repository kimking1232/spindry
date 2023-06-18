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
        $request->validate(
            [
                'title' => 'required|min:5|max:10',
                'logo' => 'required|img|mimes:jpg,jpng,png,gif,svg|max2048'
            ],
            [
                'title.required' => 'Kolom TITLE Tidak Boleh Kosong'
            ],
        )
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        //
    }
}
