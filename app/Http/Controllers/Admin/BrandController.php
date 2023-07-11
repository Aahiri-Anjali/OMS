<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BrandDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\SubBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BrandController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:brand-view|brand-create|brand-update|brand-delete', ['only' => ['create', 'store', 'edit', 'destroy']]);
        $this->middleware('permission:brand-view', ['only' => ['create']]);
        $this->middleware('permission:brand-create', ['only' => ['store']]);
        $this->middleware('permission:brand-update', ['only' => ['edit']]);
        $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
    }

    public function create(BrandDatatable $datatable)
    {
        return $datatable->render('admin.brands.list');
    }

    public function store(BrandRequest $request)
    {
        $brand = Brand::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        if ($brand) {
            return response()->json(['status' => 200, 'data' => 'Brand inserted']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $brand = Brand::where('id', $id)->first();
            if ($brand) {
                return response()->json(['status' => 200, 'data' => $brand]);
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
            $brand = Brand::where('id', $id)->first();
            $subbrand = SubBrand::where('brand_id', $id)->get();
            if (!$subbrand->isEmpty()) {
                return response()->json(['status' => 500, 'data' => 'Brand cannot be deleted, there are sub-brands']);
            } else {
                if ($brand) {
                    $delete = $brand->delete();
                    if ($delete) {
                        return response()->json(['status' => 200, 'data_table_id' => 'branddatatable-table']);
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
}
