<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\SubBrand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
   

    public function store(BrandRequest $request)
    {
        $brand = Brand::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        if ($brand) {
            return response()->json(['status' => 200, 'data' => 'Brand inserted', 'brand' => $brand]);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $brand = Brand::where('id', $id)->first();
            $subbrand = SubBrand::where('brand_id', $id)->get();
            if (!$subbrand->isEmpty()) {
                return response()->json(['status' => 500, 'data' => 'Brand cannot be deleted, there are sub-brands']);
            } else {
                if ($brand) {
                    $delete = $brand->delete();
                    if ($delete) {
                        return response()->json(['status' => 200, 'data' => 'Brand deleted']);
                    } else {
                        return response()->json(['status' => 500, 'data' => 'Something went wrong']);
                    }
                } else {
                    return response()->json(['status' => 500, 'data' => 'ID is not correct']);
                }
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }

    public function view($id)
    {
        if(isset($id) && !empty($id))
        {
            $brand = Brand::where('id',$id)->get();
            if($brand->isEmpty())
            {
                return response()->json(['status'=>500,'data'=>'ID ids not correct']);
            }else{
                return response()->json(['status'=>200,'data'=>$brand]);
            }
        }
    }

    public function list()
    {
        $brands = Brand::all();
        return response()->json(['status'=>200,'data'=>$brands]);
    }
}
