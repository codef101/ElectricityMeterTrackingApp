<?php

namespace App\Http\Livewire;

use App\Models\MeterNumber;
use App\Models\Consumer;
use App\Http\Controllers\InvoiceController;
use Livewire\Component;
use Livewire\WithPagination;
use DB;

class MetersTable extends Component
{
    use WithPagination;

    //Default number of rows when rendered
    public $perPage = 10;

    //my search bar (empty by default)
    public $search = '';

    //ordering the contents
    public $orderBy = 'MeterID';
    public $orderAsc = true;


    //updating patch
    //editing functionality ***************************************************
    //updating
    public $ConsumerID ,$Date,$consumerPointer, $BuildingName, $ConsumerName, $MeterNumber, $TotalVolume, $TotalUnits, $PrincipleAmount, $PrincipleAmountExclVat, $VAT, $ArrearsAmount, $TarrifIndex,$MeterID;

    //*******************The dropdown */
    public function dropDown()
    {
        $consumers = Consumer::all();

        //$consumers = DB::table('consumertable')
        //->select('ConsumerName')
        //->get();

        return view('home',[
            'consumerPointer' => $consumers
        ]);
    }
    //*****************DropDown */

    protected function rules()
    {
        return [
            'Date' => 'string',
            'BuildingName' => 'string',
            'ConsumerName' => 'string',
            'MeterNumber' => 'string',
            'TotalVolume' => 'string',
            'TotalUnits' => 'string',
            'PrincipleAmount' => 'string',
            'PrincipleAmountExclVat' => 'string',
            'VAT' => 'string',
            'ArrearsAmount' => 'string',
            'TarrifIndex' => 'string',
        ];
    }


    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function storeConsumer()
    {
       //dd($request->all());
        Consumer::create([
            'ConsumerName' => $this->ConsumerName,
        ]);
        session()->flash('message','Added Successfully');
        return redirect('/home');
        $this->resetInputFields();
    }

    public function editStudent(int $MeterID)
    {
        $student = MeterNumber::find($MeterID);
        if($student){
            $this->MeterID = $student->MeterID;
            $this->Date = $student->Date;
            $this->BuildingName = $student->BuildingName;
            $this->ConsumerName = $student->ConsumerName;
            $this->MeterNumber = $student->MeterNumber;
            $this->TotalVolume = $student->TotalVolume;
            $this->TotalUnits = $student->TotalUnits;
            $this->PrincipleAmount = $student->PrincipleAmount;
            $this->PrincipleAmountExclVat = $student->PrincipleAmountExclVat;
            $this->VAT = $student->VAT;
            $this->ArrearsAmount = $student->ArrearsAmount;
            $this->TarrifIndex = $student->TarrifIndex;
        }else{
            return redirect()->to('/home');
        }
    }

    public function update()
    {
        //$validatedData = $this->validate();

        MeterNumber::where('MeterID',$this->MeterID)->update([
            'Date' => $this->Date,
            'BuildingName' => $this->BuildingName,
            'ConsumerName' => $this->ConsumerName,
            'MeterNumber' => $this->MeterNumber,
            'TotalVolume' => $this->TotalVolume,
            'TotalUnits' => $this->TotalUnits,
            'PrincipleAmount' =>$this->PrincipleAmount,
            'PrincipleAmountExclVat' => $this->PrincipleAmountExclVat,
            'VAT' => $this->VAT,
            'ArrearsAmount' => $this->ArrearsAmount,
            'TarrifIndex' => $this->TarrifIndex
        ]);

        DB::table('users')->insert([
            ['email' => 'picard@example.com', 'votes' => 0],
            ['email' => 'janeway@example.com', 'votes' => 0],
        ]);

        session()->flash('message',' Updated Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
        return redirect('/home');
    }


    public function deleteStudent(int $MeterID)
    {
        $this->MeterID = $MeterID;
    }

    public function destroyConsumer($id)
    {
        Consumer::where('id',$id)->delete();
        session()->flash('message','Deleted Successfully');
        return redirect('/home');
    }

    public function closeModal()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->Date = '';
        $this->BuildingName = '';
        $this->Consumer = '';
        $this->MeterNumber = '';
        $this->TotalVolume = '';
        $this->TotalUnits = '';
        $this->PrincipleAmount = '';
        $this->PrincipleAmountExclVat = '';
        $this->VAT = '';
        $this->ArrearsAmount = '';
        $this->TarrifIndex = '';
    }

    //************************************************************************** */

    public function render()
    {
        //USE THIS TO ITERATE THROUGH FOREACH *consumerPointer*
        $this->consumerPointer=Consumer::get();

        //use this to render my consumer table for C.R.U.D
        $this->consumers = Consumer::all();

        //passing a parameter for the for table for loop to the view via the controller
        return view('livewire.meters-table',[
            'meterNumbers' =>  MeterNumber::search($this->search)
                ->where('ConsumerName','LIKE','UNALLOCATED')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),
        ]);
    }
}
