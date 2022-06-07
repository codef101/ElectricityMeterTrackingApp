<?php

namespace App\Http\Livewire;

use App\Models\Meter;
use App\Models\Consumption;
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

    public $ConsumptionID, $ConsumerID ,$Date,$consumerPointer, $BuildingName, $ConsumerName, $MeterNumber, $TotalVolume, $TotalUnits, $PrincipleAmount, $PrincipleAmountExclVat, $VAT, $ArrearsAmount, $TarrifIndex,$MeterID;


    protected function rules()
    {
        return [
            'ConsumerName' => 'string',
        ];
    }


    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function storeConsumer()
    {
        $validatedData = $this->validate([
            'ConsumerName' => 'required',
        ]);

        Consumer::create($validatedData);
        session()->flash('message','Added Successfully');

        //$this->resetInputFields();
        return redirect('/home');
    }

    public function editStudent(int $id)
    {
        $student = Consumption::find($id);
        if($student){
            /*$this->id = $student->id;
            $this->Date = $student->Date;
            $this->BuildingName = $student->BuildingName;*/
            $this->ConsumerName = $student->ConsumerName;
            /*$this->MeterNumber = $student->MeterNumber;
            $this->TotalVolume = $student->TotalVolume;
            $this->TotalUnits = $student->TotalUnits;
            $this->PrincipleAmount = $student->PrincipleAmount;
            $this->PrincipleAmountExclVat = $student->PrincipleAmountExclVat;
            $this->VAT = $student->VAT;
            $this->ArrearsAmount = $student->ArrearsAmount;
            $this->TarrifIndex = $student->TarrifIndex;*/
        }else{
            return redirect()->to('/home');
        }

    }

    public function update()
    {
        //$validatedData = $this->validate();
        //dd(7); WOW OKEY I SEE...
        //INSERT THE CONSUMER NAME (IN ITS TABLE)

        //THEN INSERT THE METER NUMBER WITH A REFERENCES CONSUMER

        //THEN THE FK FROM METER TABLE WILL FILL THE CONSUMER NAME IN CONSUMPTION TABLE


        //dd($this->id);
        Consumption::where('id',1)->update([
            'ConsumerName' => $this->ConsumerName
        ]);

        /*DB::table('consumertable')->insert([
            ['ConsumerName' => $this->ConsumerName, 'MeterNumber' => $this->MeterNumber],
        ]);*/

        //session()->flash('message',' Updated Successfully');
        //$this->resetInput();
        //$this->dispatchBrowserEvent('close-modal');
        return redirect('/home');
    }


    public function deleteStudent(int $id)
    {
        $this->id = $id;
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
            'meterNumbers' =>  Consumption::all()
                //->where('ConsumerName','LIKE','UNALLOCATED')
                //->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                //->simplePaginate($this->perPage),*/
        ]);
    }
}
