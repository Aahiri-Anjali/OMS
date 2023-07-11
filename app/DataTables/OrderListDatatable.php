<?php

namespace App\DataTables;

use App\Models\Order_detail;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrderListDatatable extends DataTable
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
            ->editColumn('order_master.status', static function ($query) {
                if ($query->orderMaster->status == "created") {
                    return "<button class='btn btn-primary'>Created</button>";
                } else if ($query->orderMaster->status == "delivered") {
                    return "<button class='badge badge-success'></button>'Delivered</button>";
                } else if ($query->orderMaster->status == "invoice") {
                    return "<button class='badge badge-warning'>Invoice</button>";
                } else {
                    return "<button class='badge badge-danger'>Cancelled</button>";
                }
            })
            ->rawColumns(['order_master.status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OrderListDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order_detail $model)
    {
        return $model->with('customer', 'item', 'orderMaster')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('orderlistdatatable-table')
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
            Column::make('order_master.status')->title('Status'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'OrderList_' . date('YmdHis');
    }
}
