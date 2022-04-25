<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MeterNumber;
use DataTables;

class MeterController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(MeterNumber::select('*'))
            ->addColumn('action', 'action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
            }

        $meternumbers = MeterNumber::all();
        
        return view ('home')->with('meternumbers', $meternumbers);

        $meternumbers = MeterNumber::get();
        return view('home',compact('home'));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        Excel::import(new ExcelImport,request()->file('file'));
               
        return back()->with('status', 'The file has been imported');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = MeterNumber::select("MeterNumber")
                    ->where('MeterNumber', 'LIKE', '%'. $request->get('query'). '%')
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
            $meterNumber = new MeterNumber;
            $meterNumber->Consumer = $request->Consumer;
            $meterNumber->save();
            return redirect()->route('home')
            ->with('success','Consumer has been created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit(MeterNumber $meternumbers)
    {
        return view('edit',compact('meternumbertable'));
    }

    public function update(Request $request, MeterNumber $meternumber)
    {
        
        //updating
        $request->validate([
            'Date' => 'required',
            'BuildingName' => 'required',
            'Consumer' => 'required',
            'MeterNumber' => 'required',
            'TotalVolume' => 'required',
            'TotalUnits' => 'required',
            'PrincipleAmount' => 'required',
            'PrincipleAmountExclVat' => 'required',
            'VAT' => 'required',
            'ArrearsAmount' => 'required',
            'TarrifIndex' => 'required',
            ]);
            $MeterNumber = MeterNumber::find($id);
            $MeterNumber->BuildingName = $request->BuildingName;
            $MeterNumber->Consumer = $request->Consumer;
            $MeterNumber->MeterNumber = $request->MeterNumber;
            $MeterNumber->TotalVolume = $request->TotalVolume;
            $MeterNumber->TotalUnits = $request->TotalUnits;
            $MeterNumber->PrincipleAmount = $request->PrincipleAmount;
            $MeterNumber->PrincipleAmountExclVat = $request->PrincipleAmountExclVat;
            $MeterNumber->VAT = $request->VAT;
            $MeterNumber->ArrearsAmount = $request->ArrearsAmount;
            $MeterNumber->TarrifIndex = $request->TarrifIndex;
            $MeterNumber->save();
            return redirect()->route('home')
            ->with('success','Consumer info Has Been updated successfully');
    }

    public function destroy($id)
    {
        //
        $com = MeterNumber::where('id',$request->id)->delete();
        return Response()->json($com);
    }
}
