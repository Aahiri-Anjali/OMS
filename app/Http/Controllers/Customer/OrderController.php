<?php

namespace App\Http\Controllers\Customer;

use App\DataTables\OrderDatatable;
use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use App\Models\ItemMaster;
use App\Models\Order_detail;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    public function create(OrderDatatable $datatable)
    {
        $items = ItemMaster::all();
        return $datatable->render('customer.order.list', compact('items'));
    }

    public function price(Request $request)
    {
        $item = ItemMaster::where('id', $request->id)->first();
        if ($item) {
            return response()->json(['status' => 200, 'data' => $item]);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $item = ItemMaster::where('id', $request->item)->first();
        $amount = $item->sellprice * $request->quantity;
        $order = Order_detail::updateOrCreate(['id' => $request->id], [
            'order_uid' => 'O-' . mt_rand('00001', '99999'),
            'customer_id' => Auth::guard('customer')->user()->id,
            'item_id' => $request->item,
            'price' => $item->sellprice,
            'quantity' => $request->quantity,
            'amount' => $amount,
            'date' => date('Y-m-d'),
        ]);

        if(!$request->id && empty($request->id) && $order)
        {
            $order_master = OrderMaster::create(['order_detail_id'=>$order->id,'date'=>date('Y-m-d'),'status'=>'created']);
        }

        if ($order) {
            return response()->json(['status' => 200, 'data' => 'Order recorded']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $order = Order_detail::where('id', $id)->first();
            if ($order) {
                return response()->json(['status' => 200, 'data' => $order]);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }


    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $order = Order_detail::where('id', $id)->first();
            if($order){
            $delete = $order->delete();
            if ($delete) {
                return response()->json(['status' => 200, 'data_table_id' => 'orderdatatable-table']);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        }else{
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }



}
