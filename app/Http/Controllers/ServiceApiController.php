<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function getData()
    {
        $services = Service::all();
        return response()->json($services);
    }
}
