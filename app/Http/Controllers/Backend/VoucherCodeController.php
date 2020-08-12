<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherCodeController extends Controller
{
   public function __construct()
   {
   	$this->middleware('auth:admin');
   }

   public function index()
   {
   	$data = 'Voucher code';

   	return view('backend.voucher_code.index', compact('data'));
   }
}
