<?php

namespace App\Exports;

use App\Models\ItemMaster;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
  
class ItemExport implements FromView
{
    // FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithEvents

    /**
     * @return \Illuminate\Support\Collection
     */

     public function view(): View
    {
        return view('admin.itemmaster.excel', [
            'items' => ItemMaster::all()
        ]);
    }

    // public function headings(): array
    // {
    //     return [
    //         'Brand Name',
    //         'SubBrand Name',
    //         'Category Name',
    //         'Subcategory Name',
    //         'Item Name',
    //         'Item Code',
    //         'Item Price',
    //     ];
    // }

    // public function map($item): array
    // {
    //     return [
    //         $item->brand->name,
    //         $item->subbrand->name,
    //         $item->category->name,
    //         $item->subcategory->name,
    //         $item->item_name,
    //         $item->item_code,
    //         $item->sellprice

    //     ];
    // }

    // public function registerEvents(): array
    // {

    //     return [
    //         AfterSheet::class    => function (AfterSheet $event) {
    //             $event->sheet->getDelegate()->getStyle('A1:G1')->getFont()->setSize(14)->setBold(true);
    //             //             $event->sheet->getActiveSheet()->getStyle('A1:G1')
    //             // ->getAlignment()->setWrapText(true);
    //             $event->sheet->getStyle('A1:G1')->applyFromArray([
    //                 'borders' => [
    //                     'outline' => [
    //                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
    //                         'color' => ['black' => '000000'],
    //                     ],
    //                 ],
    //             ]);
    //         },
    //     ];
    // }

    // public function  collection()
    // {
    //     return ItemMaster::select('brand_id', 'sub_brand_id', 'category_id', 'subcategory_id', 'item_name', 'item_code', 'sellprice')->with('brand', 'subbrand', 'category', 'subcategory')->get();
    // }
}
