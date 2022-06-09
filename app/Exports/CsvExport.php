<?php

namespace App\Exports;

use App\Models\Consumption;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class CsvExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('consumptions')->join('meters', 'meters.id','=', 'consumptions.meter_id')->join('consumers','consumers.id','=','meters.consumer_id')->get();
        return $data;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Date", "Building Name", "TotalVolume", "TotalUnits", "PrincipleAmount", "PrincipleAmountExclVat", "VAT", "ArrearsAmount", "TarrifIndex","MeterNumber","ConsumerName"];
    }
}
