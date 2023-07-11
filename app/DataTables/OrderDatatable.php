<?php

namespace App\DataTables;

use App\Models\Customer;
use App\Models\Order_detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', static function ($query) {
                $id = Crypt::encryptString($query->id);
                return "<div class='d-flex'><button value='" . $id . "' id='edit' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#orderModal'><i class='fa fa-edit'></i></button>&nbsp;&nbsp;
                <button value='" . $id . "' id='delete' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></div>";
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OrderDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order_detail $model)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        return $model->where('customer_id',$customer_id)->with('customer','item')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('orderdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('#')->data('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('order_uid'),
            Column::make('customer.name')->title('Customer Name'),
            Column::make('item.item_name')->title('Item Name'),
            Column::make('date'),
            Column::make('price'),
            Column::make('quantity'),
            Column::make('amount'),
            Column::make('action'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Order_' . date('YmdHis');
    }
}
