<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubCategoryDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\ItemCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SubCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subcategory-view|subcategory-create|subcategory-update|subcategory-delete', ['only' => ['create', 'store', 'edit', 'destroy']]);
        $this->middleware('permission:subcategory-view', ['only' => ['create']]);
        $this->middleware('permission:subcategory-create', ['only' => ['store']]);
        $this->middleware('permission:subcategory-update', ['only' => ['edit','update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
    }

    public function create(SubCategoryDatatable $datatable)
    {
        $categories = ItemCategory::all();
        return $datatable->render('admin.subcategory.list', compact('categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        $subcategory = SubCategory::create([
            'category_id' => $request->category_type,
            'name' => $request->name,
        ]);
        if ($subcategory) {
            return response()->json(['status' => 200, 'data' => 'SubCategory inserted']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $subcategory = SubCategory::where('id', $id)->with('category')->first();
            if ($subcategory) {
                return response()->json(['status' => 200, 'data' => $subcategory]);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }

    public function update(Request $request)
    {
        $update = SubCategory::find($request->id)->update(['name' => $request->name, 'category_id' => $request->category_type]);
        if ($update) {
            return response()->json(['status' => 200, 'data' => 'Updated Successfully']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $subcategory = SubCategory::where('id', $id)->first();
            if ($subcategory) {
                $delete = $subcategory->delete();
                if ($delete) {
                    return response()->json(['status' => 200, 'data_table_id' => 'subcategorydatatable-table']);
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
}
