<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\ItemCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function store(SubCategoryRequest $request)
    {
        $category_type = ItemCategory::where('id', $request->category_type)->get();
            $subcategory = SubCategory::updateOrCreate(['id' => $request->id], [
                'category_id' => $request->category_type,
                'name' => $request->name,
            ]);
            if ($subcategory) {
                return response()->json(['status' => 200, 'data' => 'SubCategory inserted', 'SubCategory' => $subcategory]);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
    }

    public function update(Request $request)
    {
        $update = SubCategory::find($request->id)->update(['name' => $request->name, 'category_id' => $request->category_type]);
        if ($update) {
            return response()->json(['status' => 200, 'data' => 'Updated Successfully', 'subcategory' => $update]);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $subcategory = SubCategory::where('id', $id)->first();
            if ($subcategory) {
                $delete = $subcategory->delete();
                if ($delete) {
                    return response()->json(['status' => 200, 'data' => 'SubCategory deleted']);
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

    public function view($id)
    {
        if(isset($id) && !empty($id))
        {
            $subcategory = SubCategory::where('id',$id)->get();
            if($subcategory->isEmpty())
            {
                return response()->json(['status'=>500,'data'=>'ID ids not correct']);
            }else{
                return response()->json(['status'=>200,'data'=>$subcategory]);
            }
        }
    }

    public function list()
    {
        $subcategory = SubCategory::all();
        return response()->json(['status'=>200,'data'=>$subcategory]);
    }
}
