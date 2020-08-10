<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShippingRate;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Traits\UserLogs;

class ShippingRateController extends Controller
{
	use UserLogs;

   public function getShippingRate()
   {
   	$shipping_rate = ShippingRate::limit(1)->get();

   	return response()->json($shipping_rate);

   }

   public function setShippingRate(Request $request)
   {
   	$request->validate([
            'manila_rate' => "required",
            'province_rate' => "required",
            'qty_order_discount' => "required",
            'discount_percent' => "required",
        ]);

   	date_default_timezone_set("Asia/Manila");

   	$shipping_rate = new ShippingRate();
   	$shipping_rate->manila_rate = round($request->manila_rate, 2);
   	$shipping_rate->province_rate = round($request->province_rate, 2); 
   	$shipping_rate->order_quantity = (int)$request->qty_order_discount;
   	$shipping_rate->discount_percentage = (int)$request->discount_percent;
   	$shipping_rate->save();

   	$array_params = [
         'id' => $request->admin_id,
         'action' => 'Set shipping rate'
     	];

      $this->createUserLog($array_params);

      $response = array('success'=>true);

      return response()->json($response);
   }

   public function updateShippingRate(Request $request, ShippingRate $shippingRate)
   {
   	$request->validate([
            'manila_rate' => "required",
            'province_rate' => "required",
            'qty_order_discount' => "required",
            'discount_percent' => "required",
        ]);

   	$shippingRate->manila_rate = round($request->manila_rate, 2);
   	$shippingRate->province_rate = round($request->province_rate, 2); 
   	$shippingRate->order_quantity = (int)$request->qty_order_discount;
   	$shippingRate->discount_percentage = (int)$request->discount_percent;
   	$shippingRate->update();

   	$array_params = [
         'id' => $request->admin_id,
         'action' => 'Updated shipping rate'
     	];

      $this->createUserLog($array_params);

      $response = array('success'=>true);

      return response()->json($response);
   }
}
