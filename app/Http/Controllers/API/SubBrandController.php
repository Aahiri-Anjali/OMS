<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubBrandRequest;
use App\Models\SubBrand;
use Illuminate\Http\Request;

class SubBrandController extends Controller
{
    public function store(SubBrandRequest $request)
    {
        $subbrand = SubBrand::updateOrCreate(['id' => $request->id], [
            'brand_id' => $request->brand_type,
            'name' => $request->name,
        ]);
        if ($subbrand) {
            return response()->json(['status' => 200, 'data' => 'SubBrand inserted', 'SubBrand' => $subbrand]);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $subbrand = SubBrand::where('id', $id)->first();
            if($subbrand){
            $delete = $subbrand->delete();
            if ($delete) {
                return response()->json(['status' => 200, 'data' => 'Sub Brand deleted']);
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

    public function view($id)
    {
        if(isset($id) && !empty($id))
        {
            $subbrand = SubBrand::where('id',$id)->get();
            if($subbrand->isEmpty())
            {
                return response()->json(['status'=>500,'data'=>'ID ids not correct']);
            }else{
                return response()->json(['status'=>200,'data'=>$subbrand]);
            }
        }
    }

    public function list()
    {
        $subbrand = SubBrand::all();
        return response()->json(['status'=>200,'data'=>$subbrand]);
    }
}
