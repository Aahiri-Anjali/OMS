<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CustomerDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:customer-view|customer-create|customer-update|customer-delete', ['only' => ['create', 'store', 'edit', 'destroy']]);
        $this->middleware('permission:customer-view', ['only' => ['create']]);
        $this->middleware('permission:customer-create', ['only' => ['store']]);
        $this->middleware('permission:customer-update', ['only' => ['edit']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }



    public function create(CustomerDatatable $datatable)
    {
        return $datatable->render('admin.customer.list');
    }

    public function store(CustomerRequest $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $customer = Customer::where('id', $request->id)->first();
            $customer->update([
                'email' => $customer->email,
                'password' => $customer->password,
                'contact_no' => $request->contact_no,
                'VATNO' => $request->vatno,
                'name' => $request->name,
            ]);
            if ($customer) {
                return response()->json(['status' => 200, 'data' => 'Customer updated']);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        } else {
            $customer = Customer::Create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'contact_no' => $request->contact_no,
                'VATNO' => $request->vatno,
            ]);

            if ($customer) {
                return response()->json(['status' => 200, 'data' => 'Customer inserted']);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $customer = Customer::where('id', $id)->first();
            if ($customer) {
                return response()->json(['status' => 200, 'data' => $customer]);
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
            $customer = Customer::where('id', $id)->first();
            if ($customer) {
                $delete = $customer->delete();
                if ($delete) {
                    return response()->json(['status' => 200, 'data_table_id' => 'customerdatatable-table']);
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
