<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemMasterRequest;
use App\Models\ItemMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ItemMasterController extends Controller
{
    public function store(ItemMasterRequest $request)
    {
        $code = mt_rand(000000000000, 999999999999);
        if ($this->codeExists($code)) {
            $code = mt_rand(000000000000, 999999999999);
        }
        $itemmaster = ItemMaster::find($request->id);
        $insert = ItemMaster::updateOrCreate(['id' =>  $request->id], [
            'brand_id' => $request->brand_type,
            'sub_brand_id' => $request->subbrand_type,
            'category_id' => $request->category_type,
            'subcategory_id' => $request->subcategory_type,
            'item_name' => $request->item_name,
            'item_code' => $code ?? $itemmaster->item_code,
            'sellprice' => $request->sellprice,
        ]);
        if ($insert) {
            return response()->json(['status' => 200, 'data' => 'Brand inserted']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function codeExists($code)
    {
        return ItemMaster::whereItemCode($code)->exists();
    }

    
    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $item = ItemMaster::find($id);
            if ($item) {
                $delete =  $item->delete();
                if ($delete) {
                    return response()->json(['status' => 200, 'data' => 'Item deleted']);
                } else {
                    return response()->json(['status' => 500, 'data' => 'Something went wrong']);
                }
            } else {
                return response()->json(['status' => 500, 'data' => 'ID is not correct']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }

    public function list()
    {
        $items = ItemMaster::all();
        return response()->json(['status'=>200,'data'=>$items]);
    }
}
