<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use App\Exports\CsvExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Consumer;
use App\Models\Meter;
use App\Models\Consumption;
use DataTables;
use DB;

class MeterController extends Controller
{
    public $ConsumerID ;
    public $consumers;
    public $Date;
    public $BuildingName;
    public $ConsumerName;
    public $Meter;
    public $TotalVolume;
    public $TotalUnits;
    public $PrincipleAmount;
    public $PrincipleAmountExclVat;
    public $VAT;
    public $ArrearsAmount;
    public $TarrifIndex;
    public $MeterID;

    public function test()
    {

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Meter::select('*'))
            ->addColumn('action', 'action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        $consumptions = Consumption::with('meter')
                    ->paginate(5);

        foreach ($consumptions as $consumption) {
            $consumer = Consumer::where('id','=', $consumption->meter->consumer_id)->first();
            $consumer != null ? $consumption->ConsumerName = $consumer->ConsumerName : false;
        }
        return view('home',['meternumbers'=> $consumptions]);
    }

    //*******************The dropdown */
    public function dropDown()
    {
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {

            Consumption::truncate();
            Excel::import(new ExcelImport, request()->file('file'));
            DB::table('consumptions')->where('BuildingName', '=', null)->delete();
            return back()->with('status', 'The file has been imported');
        } else {
            return back();
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function export()
    {
        return Excel::download(new CsvExport, 'CSV.xlsx');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = Meter::select("Meter")
                    ->where('Meter', 'LIKE', '%'. $request->get('query'). '%')
                    ->get();

        return response()->json($data);
    }



    public function create()
    {
        //creating a new consumer
        return view('create');
    }

    public function store(Request $request)
    {
        //storing a new estate
        $request->validate([
            'Consumer' => 'required'
            ]);
        $Consumer = new Consumer;
        $Consumer->Consumer = $request->input('Consumer');
        $Consumer->save();
        return redirect()->route('home')
            ->with('success', 'Consumer has been created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit(Meter $id)
    {
        return view('edit', compact('meternumbertable'));
    }

    public function update(Request $request, Meter $meternumber)
    {
        //updating
        $request->validate([
            'Date' => 'required',
            'BuildingName' => 'required',
            'ConsumerName' => 'required',
            'Meter' => 'required',
            'TotalVolume' => 'required',
            'TotalUnits' => 'required',
            'PrincipleAmount' => 'required',
            'PrincipleAmountExclVat' => 'required',
            'VAT' => 'required',
            'ArrearsAmount' => 'required',
            'TarrifIndex' => 'required',
            ]);
        $Meter = Meter::find($id);
        $Meter->BuildingName = $request->BuildingName;
        $Meter->Consumer = $request->Consumer;
        $Meter->Meter = $request->Meter;
        $Meter->TotalVolume = $request->TotalVolume;
        $Meter->TotalUnits = $request->TotalUnits;
        $Meter->PrincipleAmount = $request->PrincipleAmount;
        $Meter->PrincipleAmountExclVat = $request->PrincipleAmountExclVat;
        $Meter->VAT = $request->VAT;
        $Meter->ArrearsAmount = $request->ArrearsAmount;
        $Meter->TarrifIndex = $request->TarrifIndex;
        $Meter->save();
        return redirect()->route('home')
            ->with('success', 'Consumer info Has Been updated successfully');
    }

    public function destroy($id)
    {
        //
        $com = Meter::where('id', $request->id)->delete();
        return Response()->json($com);
    }
}
