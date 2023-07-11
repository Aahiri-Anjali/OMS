<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
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

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $customer = Customer::find($id);
            if ($customer) {
                $delete =  $customer->delete();
                if ($delete) {
                    return response()->json(['status' => 200, 'data' => 'Customer deleted']);
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

    public function list()
    {
        $customers = Customer::all();
        return response()->json(['status'=>200,'data'=>$customers]);
    }
}
