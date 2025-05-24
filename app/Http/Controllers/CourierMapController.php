<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;

class CourierMapController extends Controller
{
    public function index()
    {
        $couriers = Courier::all();
        return view('admin.courier-map', compact('couriers'));
    }
} 