<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingRateController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

 	public function index()
 	{
 		return view('backend.shipping_rate.index');
 	}
}
