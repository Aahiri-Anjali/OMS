<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemCategoryDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCategoryRequest;
use App\Models\ItemCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ItemCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:itemcategory-view|itemcategory-create|itemcategory-update|itemcategory-delete', ['only' => ['create', 'store', 'edit', 'destroy']]);
        $this->middleware('permission:itemcategory-view', ['only' => ['create']]);
        $this->middleware('permission:itemcategory-create', ['only' => ['store']]);
        $this->middleware('permission:itemcategory-update', ['only' => ['edit']]);
        $this->middleware('permission:itemcategory-delete', ['only' => ['destroy']]);
    }


    public function create(ItemCategoryDatatable $datatable)
    {
        return $datatable->render('admin.category.list');
    }

    public function store(ItemCategoryRequest $request)
    {
        $category = ItemCategory::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        if ($category) {
            return response()->json(['status' => 200, 'data' => 'Category inserted']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $category = ItemCategory::where('id', $id)->first();
            if ($category) {
                return response()->json(['status' => 200, 'data' => $category]);
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
            $category = ItemCategory::where('id', $id)->first();
            $subcategory = SubCategory::where('category_id', $id)->get();
            if (!$subcategory->isEmpty()) {
                return response()->json(['status' => 500, 'data' => 'Category cannot be deleted, there are subcategories']);
            } else {
                if ($category) {
                    $delete = $category->delete();
                    if ($delete) {
                        return response()->json(['status' => 200, 'data_table_id' => 'itemcategorydatatable-table']);
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
