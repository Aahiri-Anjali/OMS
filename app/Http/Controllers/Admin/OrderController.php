<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderListDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list(OrderListDatatable $datatable)
    {
        return $datatable->render('admin.order.list');
    }
}
