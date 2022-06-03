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

    public function test()
    {
        // Here you have consumers with meters
        /*$consumers = Consumer::with('meter')->get();
        dd($consumers);*/

        //continue
        $consumers = Consumer::with('meter')->get();

        foreach ($consumers as $key => $consumer) {
            $consumptions = Consumption::where('meter_id','=',$consumer->meter->id);
            // there you go, you now have all consumptions from one user
            //ill study it further..so i should be well off?
        }

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Meter::select('*'))
            ->addColumn('action', 'action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
            }

        $meternumbers = Meter::all();

        return view ('home')->with('meternumbers', $meternumbers);

        $meternumbers = Meter::get();
        return view('home',compact('home'));


    }
    public $ConsumerID ,$consumers,$Date, $BuildingName, $ConsumerName, $Meter, $TotalVolume, $TotalUnits, $PrincipleAmount, $PrincipleAmountExclVat, $VAT, $ArrearsAmount, $TarrifIndex,$MeterID;

    //*******************The dropdown */
    public function dropDown()
    {

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        //if import button is pressed when empty it needs to display a message and not truncate
        if($request->hasFile('file'))
        {

            Consumption::truncate();
            Excel::import(new ExcelImport,request()->file('file'));

            //replacing NULLS with UNALLOCATED
                    DB::table('consumptions')
                ->whereNull('ConsumerName')
                ->update(['ConsumerName' => "UNALLOCATED"]);

            //DELETE EMPTY ROWS
            DB::table('consumptions')->where('BuildingName', '=', null)->delete();

            //Auto filling consumers in meterstable
            //$info = Consumer::find(36)->Meter;
            //dd(7);
            /*
            $meternumbers = Meter::all();
            $consumers = Consumer::all();
            // loop through the input
            foreach ($meternumbers as $row ) { //foreach (array_combine($meternumbers, $consumers) as $row => $crow) {
                // Get consumer name
                $consumer_name = DB::table('consumertable')
                                    ->select('ConsumerName')
                                    ->where('Meter','=',$row->Meter)
                                    ->get();
                // Get meternumber name
                $meter_number = DB::table('consumertable')
                                    ->select('Meter')
                                    ->where('Meter','=',$row->Meter)
                                    ->get();

                // update consumername column in meter table
                //DB::raw('update meternumbertable set ConsumerName = '.$consumer_name );
                dd($consumer_name,'ConsumerName');
                DB::table('meternumbertable')
                    ->where('Meter','=', $row->Meter)
                    ->update(['ConsumerName' => 'UNALLOCATED']); //This here is returning an array?so it seems...best answer so far = $consumer_name
            }*/

            return back()->with('status', 'The file has been imported');
        }
        else
        {
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
            ->with('success','Consumer has been created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit(Meter $id)
    {
        return view('edit',compact('meternumbertable'));
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
            ->with('success','Consumer info Has Been updated successfully');
    }

    public function destroy($id)
    {
        //
        $com = Meter::where('id',$request->id)->delete();
        return Response()->json($com);
    }
}
