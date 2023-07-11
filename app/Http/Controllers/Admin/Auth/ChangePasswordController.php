<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use App\Interfaces\Admin\ChangePasswordInterface;

class ChangePasswordController extends Controller
{
    private ChangePasswordInterface $ChangePasswordInterface;

    public function __construct(ChangePasswordInterface $ChangePasswordInterface)
    {
        $this->ChangePasswordInterface = $ChangePasswordInterface;
    }

    public function index()
    {
        return view('admin.auth.changepassword');

    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->all();
        $change = $this->ChangePasswordInterface->changepassword($data);
        if($change)
        {
            return response()->json($change);
        }
    }
}
