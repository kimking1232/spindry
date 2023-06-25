<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;

class HeroApiController extends Controller
{
    public function getData()
    {
        $heroes = Hero::all();
        return response()->json($heroes);
    }
}
