<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // pencairan index/view
        $q = $request->q;
        $pagination = $request->has('pagination') ? $request->pagination:10;
        if($q)
        {
            // pencarian all
            // $heroes = Hero::where('title', 'like', '%'.$q.'%')->get();
            // pencarian pagination
            $heroes = Hero::where('title', 'like', '%'.$q.'%')->paginate($pagination);
        } else {
            // menampilkan seluruh data index/view
            // $heroes = Hero::all();
            // menampilkan pagination data index/view
            $heroes = Hero::paginate($pagination);

        }
        //vardump cek data didalam tabel database
        // return $heroes;
        return view('pages.hero', compact('heroes', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.hero-create');
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
            'subtitle' => 'required|min:10|max:50',
            'background' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ],
        [
            'title.required' => 'Kolom TITLE Tidak Boleh Kosong !',
            'title.min' => 'kolom TITLE terlalu pendek !',
            'title.max' => 'kolom TITLE terlalu panjang !',
            'subtitle.required' => 'Kolom SUBTITLE Tidak Boleh Kosong !',
            'subtitle.min' => 'kolom SUBTITLE tertalu pendek !',
            'subtitle.max' => 'kolom SUBTITLE tertalu panjang !',
            'background.required' => 'Kolom BACKGROUND Tidak Boleh Kosong !',
            'background.image' => 'Kolom BACKGROUND harus format jpeg, png, jpg, gif, svg !',
            'backgorund.max' => 'File pada Kolom BACKGROUND terlalu besar maksimal 2MB !',
        ]
    );

        $background = $request->file('background');
        $filename = time().'-'.rand().'-'. $background->getClientOriginalName();
        $background->move(public_path('/img/heroes/'), $filename);

        $status = $request->has('status')? 'show' : 'hide';

        Hero::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'background' => $filename,
            'status' => $status,
        ]);
        return redirect('/hero')->with('success', 'Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hero $hero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hero $hero)
    {
        // return $hero;
        return view('pages.hero-edit', compact('hero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero $hero)
    {
        // return $request;
        $request->validate([
            'title' => 'required|min:5|max:10',
            'subtitle' => 'required|min:10|max:50',
            'background' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ],
        [
            'title.required' => 'Kolom TITLE Tidak Boleh Kosong !',
            'title.min' => 'kolom TITLE tertalu pendek !',
            'title.max' => 'kolom TITLE tertalu panjang !',
            'subtitle.required' => 'Kolom SUBTITLE Tidak Boleh Kosong !',
            'subtitle.min' => 'kolom SUBTITLE tertalu pendek !',
            'subtitle.max' => 'kolom SUBTITLE tertalu panjang !',
            'background.required' => 'Kolom BACKGROUND Tidak Boleh Kosong !',
            'background.image' => 'Kolom BACKGROUND harus format jpeg, png, jpg, gif, svg !',
            'backgorund.max' => 'File pada Kolom BACKGROUND terlalu besar maksimal 2MB !',
        ]
    );
        
        $status = $request->has('status')? 'show' : 'hide';

        if($request->has('background'))
        {
            unlink(public_path('/img/heroes/'.$hero->background));
            $background = $request->file('background');
            $filename = time().'-'.rand().'-'. $background->getClientOriginalName();
            $background->move(public_path('/img/heroes/'), $filename);

            Hero::where('id',$hero->id)->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'background' => $filename,
                'status' => $status,
            ]);
        }else{
            Hero::where('id',$hero->id)->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'status' => $status,
            ]);
        }
        
        return redirect('/hero');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero $hero)
    {
        if(file_exists(public_path('/img/heroes/'.$hero->background ))){
            unlink(public_path('/img/heroes/'.$hero->background));
        }
        Hero::destroy('id', $hero->id);
        return redirect('/hero');
    }
}
