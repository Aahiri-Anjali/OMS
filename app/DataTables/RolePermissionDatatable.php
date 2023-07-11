<?php

namespace App\DataTables;

// use App\Models\RolePermissionDatatable;

use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RolePermissionDatatable extends DataTable
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
            ->editColumn('permissions',function($query){
            $permissions = Role::where('id', $query->id)->first()->permissions;
                $str="";
                 foreach($permissions as $permission)
                 {
                    $str .= "<button type='button'  class='badge badge-primary'>".$permission->name."</button></i>&nbsp;&nbsp;&nbsp;";                
                 }
                 return $str;
            })
            ->addColumn('action', static function ($query) {
                $id = Crypt::encryptString($query->id);
                return "<div class='d-flex'><a role='button' href='".route('admin.role.edit',['id'=>$id])."' value='" . $id . "' id='edit' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;
                <button value='" . $id . "' id='delete' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></div>";
            })
            ->addIndexColumn()
            ->rawColumns(['permissions','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RolePermissionDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
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
            ->setTableId('rolepermissiondatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
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
            Column::make('name'),
            Column::make('permissions'),
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
        return 'RolePermission_' . date('YmdHis');
    }
}
