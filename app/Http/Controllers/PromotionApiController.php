<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionApiController extends Controller
{
    public function getData()
    {
        $promotions = Promotion::all();
        return response()->json($promotions);
    }
}
