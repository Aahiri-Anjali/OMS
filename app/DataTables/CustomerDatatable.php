<?php

namespace App\DataTables;

use App\Models\Customer;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDatatable extends DataTable
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
                return "<div class='d-flex'><button value='" . $id . "' id='edit' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#customerModal'><i class='fa fa-edit'></i></button>&nbsp;&nbsp;
                <button value='" . $id . "' id='delete' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></div>";
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CustomerDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('customerdatatable-table')
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
            Column::make('id')->hidden(true),
            Column::make('email')->title('Email'),
            Column::make('name'),
            Column::make('contact_no'),
            Column::make('VATNO'),
            Column::make('created_at'),
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
        return 'Customer_' . date('YmdHis');
    }
}
