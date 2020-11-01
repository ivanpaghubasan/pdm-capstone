<?php

namespace App\Http\Controllers\Api;

use App\Notifications\DeclinedReplacementNotification;
use App\Notifications\ApprovedReplacementNotification;
use App\Notifications\ReplacedProductNotification;
use App\Models\ReplacementRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserLogs;
use Exception;

class ReplacementRequestController extends Controller
{

    use UserLogs;

	public function getCustomerRequests($customerId)
    {
        $replacements = ReplacementRequest::where('customer_id',$customerId)
            ->with('inventory.product')->get();

        return response()->json($replacements);
    }

    public function getReplacements()
    {
        $replacements = ReplacementRequest::with('inventory.product')->get();

        return response()->json($replacements);
    }

    public function details($requestId)
    {
        $details = ReplacementRequest::where('id',$requestId)->with('inventory','product')->first();

        return response()->json($details);
    }

    public function approveRequest(Request $request)
    {
        $request->validate([
            'replacement_id' => 'required'
        ]);

        date_default_timezone_set("Asia/Manila");

        try
        {
            $replacement = ReplacementRequest::where([
                'id' => $request->replacement_id,
                'status' => 'Pending'
            ])->first();

            $replacement->status = 'Approved';
            $replacement->status_update = 1;
            $replacement->request_approved = date('Y-m-d H:i:s');
            $replacement->update();

            $customer = Customer::where('id',$replacement->customer_id)->first();
            // send email
            $customer->notify(new ApprovedReplacementNotification($replacement));

            $array_params = [
                'id' => $request->admin_id,
                'action' => 'Approved replacement request of ID: '.$replacement->id
            ];

            $this->createUserLog($array_params);

            $response = ['success'=>true];
        }
        catch(Exception $ex)
        {
            $response = ['success' => false, 'msg' => $ex->getMessage()];
        }

        return response()->json($response);

    }

    public function declineRequest(Request $request)
    {
        $request->validate([
            'replacement_id' => 'required'
        ]);

        date_default_timezone_set("Asia/Manila");

        try
        {
            $replacement = ReplacementRequest::where([
                'id' => $request->replacement_id,
                'status' => 'Pending'
            ])->first();

            $replacement->status = 'Declined';
            $replacement->status_update = 1;
            $replacement->request_declined = date('Y-m-d H:i:s');
            $replacement->update();

            $customer = Customer::where('id',$replacement->customer_id)->first();
            // send email
            $customer->notify(new DeclinedReplacementNotification($replacement));

            $array_params = [
                'id' => $request->admin_id,
                'action' => 'Declined replacement request of ID: '.$replacement->id
            ];

            $this->createUserLog($array_params);

            $response = ['success'=>true];
        }
        catch(Exception $ex)
        {
            $response = ['success' => false, 'msg' => $ex->getMessage()];
        }

        return response()->json($response);
    }

    public function replaceProduct(Request $request)
    {
        $request->validate([
            'replacement_id'=> 'required'
        ]);

        date_default_timezone_set("Asia/Manila");

        $replacement = ReplacementRequest::where('id', (int)$request->replacement_id)->first();
        $inventory = Inventory::where('number', $replacement->inventory_number)->first();

        if ($inventory->inventory_stock > $replacement->quantity)
        {
            $inventory->inventory_stock -= $replacement->quantity;
            $inventory->update();

            $replacement->status = 'Replaced';
            $replacement->status_update = 1;
            $replacement->request_replaced = date('Y-m-d H:i:s');
            $replacement->update();

            $customer = Customer::where('id',$replacement->customer_id)->first();
            // send email
            $customer->notify(new ReplacedProductNotification($replacement));

            $array_params = [
                'id' => $request->admin_id,
                'action' => 'Replaced product. Inventory number: '.$replacement->inventory_number,' Order number: '.$replacement->order_number.' Quntity: '.$replacement->quantity
            ];

            $this->createUserLog($array_params);

            return response()->json(['success'=>true]);
        }

    }

    public function replacementStatusUpdate($customer)
    {
      try
      {
        $has_order = Order::where('customer_id', $customer)->count();

        if ($has_order > 0)
        {
            $status_update = ReplacementRequest::where('status_update','=',1)->count();    
        } 
        else
        {
            $status_update = null;
        }

        $response = ['count'=> $status_update];
      }
      catch(Exception $e)
      {
         $response = ['err' =>$e->getMessage()];
      }

      return response()->json($response);
        
   }

    public function updateStatus(ReplacementRequest $replacement)
    {
        $replacement->status_update = 0;
        $replacement->update();

        return response()->json(['success' => true]);
    }

    public function getViewed()
    {
        try
      {
         $status_update = ReplacementRequest::where('viewed','=',0)->count();

         $response = ['count'=> $status_update];
      }
      catch(Exception $e)
      {
         $response = ['err' =>$e->getMessage()];
      }

      return response()->json($response);
    }
}
