<?php

namespace App\Exports;

use App\Models\Consumption;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CsvExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Consumption::select("Date", "BuildingName", "ConsumerName", "MeterNumber", "TotalVolume", "TotalUnits", "PrincipleAmount", "PrincipleAmountExclVat", "VAT", "ArrearsAmount", "TarrifIndex")->get();//all();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Date", "Building Name","ConsumerName", "MeterNumber", "TotalVolume", "TotalUnits", "PrincipleAmount", "PrincipleAmountExclVat", "VAT", "ArrearsAmount", "TarrifIndex"];
    }
}
