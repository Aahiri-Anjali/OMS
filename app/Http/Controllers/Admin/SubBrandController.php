<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubBrandDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubBrandRequest;
use App\Models\Brand;
use App\Models\SubBrand;
use Illuminate\Support\Facades\Crypt;

class SubBrandController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subbrand-view|subbrand-create|subbrand-update|subbrand-delete', ['only' => ['create', 'store', 'edit', 'destroy']]);
        $this->middleware('permission:subbrand-view', ['only' => ['create']]);
        $this->middleware('permission:subbrand-create', ['only' => ['store']]);
        $this->middleware('permission:subbrand-update', ['only' => ['edit']]);
        $this->middleware('permission:subbrand-delete', ['only' => ['destroy']]);
    }

    public function create(SubBrandDatatable $datatable)
    {
        $brands = Brand::all();
        return $datatable->render('admin.subbrand.list', compact('brands'));
    }

    public function store(SubBrandRequest $request)
    {
        $subbrand = SubBrand::updateOrCreate(['id' => $request->id], [
            'brand_id' => $request->brand_type,
            'name' => $request->name,
        ]);
        if ($subbrand) {
            return response()->json(['status' => 200, 'data' => 'SubBrand inserted']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $subbrand = SubBrand::where('id', $id)->with('brand')->first();
            if ($subbrand) {
                return response()->json(['status' => 200, 'data' => $subbrand]);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }

    // public function update(Request $request)
    // {
    //     $update = SubBrand::find($request->id)->update(['name' => $request->name, 'category_id' => $request->category_type]);
    //     if ($update) {
    //         return response()->json(['status' => 200, 'data' => 'Updated Successfully']);
    //     } else {
    //         return response()->json(['status' => 500, 'data' => 'Something went wrong']);
    //     }
    // }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $subbrand = SubBrand::where('id', $id)->first();
            if($subbrand){
            $delete = $subbrand->delete();
            if ($delete) {
                return response()->json(['status' => 200, 'data_table_id' => 'subbranddatatable-table']);
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
