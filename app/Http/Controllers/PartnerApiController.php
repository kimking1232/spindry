<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerApiController extends Controller
{
    public function getData()
    {
        $partners = Partner::all();
        return response()->json($partners);
    }
}
