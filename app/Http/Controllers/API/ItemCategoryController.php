<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCategoryRequest;
use App\Models\ItemCategory;
use App\Models\ItemMaster;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ItemCategoryController extends Controller
{
    public function store(ItemCategoryRequest $request)
    {
        $category = ItemCategory::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        if ($category) {
            return response()->json(['status' => 200, 'data' => 'Category inserted', 'category' => $category]);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $category = ItemCategory::where('id', $id)->first();
            $subcategory = SubCategory::where('category_id', $id)->get();
            if (!$subcategory->isEmpty()) {
                return response()->json(['status' => 500, 'data' => 'Category cannot be deleted, there are subcategories']);
            } else {
                if ($category) {
                    $delete = $category->delete();
                    if ($delete) {
                        return response()->json(['status' => 200, 'data' => 'Item category deleted']);
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
            $category = ItemCategory::where('id',$id)->get();
            if($category->isEmpty())
            {
                return response()->json(['status'=>500,'data'=>'ID ids not correct']);
            }else{
                return response()->json(['status'=>200,'data'=>$category]);
            }
        }
    }

    public function list()
    {
        $category = ItemCategory::all();
        return response()->json(['status'=>200,'data'=>$category]);
    }

}
