<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemMasterDatatable;
use App\Exports\ItemExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemMasterRequest;
use App\Models\Brand;
use App\Models\ItemCategory;
use App\Models\ItemMaster;
use App\Models\SubBrand;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use  PDF;
class ItemMasterController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:itemmaster-view|itemmaster-create|itemmaster-update|itemmaster-delete', ['only' => ['create', 'store', 'edit', 'destroy']]);
        $this->middleware('permission:itemmaster-view', ['only' => ['create']]);
        $this->middleware('permission:itemmaster-create', ['only' => ['store']]);
        $this->middleware('permission:itemmaster-update', ['only' => ['edit']]);
        $this->middleware('permission:itemmaster-delete', ['only' => ['destroy']]);
    }



    public function create(ItemMasterDatatable $datatable)
    {
        $categories = ItemCategory::all();
        $subcategories = SubCategory::all();
        $brands = Brand::all();
        $subbrands = SubBrand::all();
        return $datatable->render('admin.itemmaster.list', compact('categories', 'subcategories', 'brands', 'subbrands'));
    }

    public function store(ItemMasterRequest $request)
    {
        $code = mt_rand(000000000000, 999999999999);
        if ($this->codeExists($code)) {
            $code = mt_rand(000000000000, 999999999999);
        }
        if (isset($request->id) && !empty($request->id)) {
            $id = Crypt::decryptString($request->id);
            $itemmaster = ItemMaster::find($id);
            $itemmaster->update([
                'brand_id' => $request->brand_type,
                'sub_brand_id' => $request->subbrand_type,
                'category_id' => $request->category_type,
                'subcategory_id' => $request->subcategory_type,
                'item_name' => $request->item_name,
                'item_code' => $itemmaster->item_code,
                'sellprice' => $request->sellprice,
            ]);
        } else {
            $itemmaster = Itemmaster::Create([
                'brand_id' => $request->brand_type,
                'sub_brand_id' => $request->subbrand_type,
                'category_id' => $request->category_type,
                'subcategory_id' => $request->subcategory_type,
                'item_name' => $request->item_name,
                'item_code' => $code,
                'sellprice' => $request->sellprice,
            ]);
        }
        if ($itemmaster) {
            return response()->json(['status' => 200, 'data' => 'Brand inserted']);
        } else {
            return response()->json(['status' => 500, 'data' => 'Something went wrong']);
        }
    }

    public function codeExists($code)
    {
        return ItemMaster::whereItemCode($code)->exists();
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $itemmaster = Itemmaster::where('id', $id)->with('brand', 'subbrand', 'category', 'subcategory')->first();
            $brands = Brand::all();
            $subbrands = SubBrand::where('brand_id', $itemmaster->brand_id)->get();
            $categories = ItemCategory::all();
            $subcategories = SubCategory::where('category_id', $itemmaster->category_id)->get();
            if ($itemmaster) {
                // return response()->json(['status' => 200, 'data' => $itemmaster,'subbrands'=>$subbrands,'brands'=>$brands]);
                return view('admin.itemmaster.edit', compact('brands', 'subbrands', 'itemmaster', 'categories', 'subcategories'));
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }

    public function brand(Request $request)
    {
        $subbrands = SubBrand::where('brand_id', $request->id)->with('brand')->get();
        return response()->json(['status' => 200, 'data' => $subbrands]);
    }

    public function category(Request $request)
    {
        $categories = SubCategory::where('category_id', $request->id)->with('category')->get();
        return response()->json(['status' => 200, 'data' => $categories]);
    }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $itemmaster = ItemMaster::where('id', $id)->first();
            if ($itemmaster) {
                $delete = $itemmaster->delete();
                if ($delete) {
                    return response()->json(['status' => 200, 'data_table_id' => 'itemmasterdatatable-table']);
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

    public function pdf(Request $request)
    {
        // $columns = ['','','item_name', 'item_code', 'sellprice']; 
        $items = ItemMaster::with('brand','category','subcategory','subbrand')->get(); 
        $pdf = PDF::loadView('admin.itemmaster.pdf', compact('items')); 
        return $pdf->download('item.pdf');

    }

    public function excel()
    {
        return Excel::download(new ItemExport, 'item.xlsx');
       
    }
}
