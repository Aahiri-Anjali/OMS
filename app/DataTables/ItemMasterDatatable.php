<?php

namespace App\DataTables;

use App\Models\ItemMaster;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;
use Picqer\Barcode\BarcodeGeneratorPNG;


class ItemMasterDatatable extends DataTable
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
            ->editColumn('barcode',function($query){
                // return DNS1DFacade :: getBarcodeSVG(route('admin.itemmaster.barcode',['id',$query->id]),'PHARMA');
                // $generator = new picqer\Barcode\BarcodeGeneratorHTML();
                // $barcode = $generator->getBarcode('120',$generator::TYPE_CODE_128);
                // return "P - $query->item_code". DNS1DFacade::getBarcodeHTML("$query->sellprice", 'EAN13',2,50);
                // return $barcode;
                $generatorPNG = new BarcodeGeneratorPNG();
                return "P - $query->item_code <br> <img src='data:image/png;base64, ".base64_encode($generatorPNG->getBarcode($query->sellprice, $generatorPNG::TYPE_CODE_128))."' />";

            })
            ->addColumn('action', static function ($query) {
                $id = Crypt::encryptString($query->id);
                return "<div class='d-flex'><a role='button' value='" . $id . "' id='edit' class='btn btn-warning btn-sm' href='".route('admin.itemmaster.edit',['id'=>$id])."'><i class='fa fa-edit'></i></a>&nbsp;&nbsp;
                <button value='" . $id . "' id='delete' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></div>";
            })
            ->rawColumns(['barcode','action'])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ItemMasterDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ItemMaster $model, Request $request)
    {
        if($request->category != "")
        {
            $model = $model->where('category_id',$request->category);
        }else if($request->subcategory != "")
        {
            $model = $model->where('subcategory_id',$request->subcategory);
        }else if($request->brand != "")
        {
            $model = $model->where('brand_id',$request->brand);
        }
        else if($request->subbrand != "")
        {
            $model = $model->where('sub_brand_id',$request->subbrand);
        }
        return $model->with('category','subcategory','brand','subbrand')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('itemmasterdatatable-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
            // ->buttons(
                // Button::make('create'),
                // Button::make('excel'),
                // Button::make('csv'),
                // Button::make('export'),
                // Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload'),
                // Button::make('colvis'),
            // );
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
            Column::make('category.name')->title('Category Name'),
            Column::make('subcategory.name')->title('Subcategory Name'),
            Column::make('brand.name')->title('Brand Name'),
            Column::make('subbrand.name')->title('SubBrand Name'),
            Column::make('item_name'),
            Column::make('item_code'),
            Column::make('barcode'),
            Column::make('sellprice'),
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
        return 'ItemMaster_' . date('YmdHis');
    }
}
