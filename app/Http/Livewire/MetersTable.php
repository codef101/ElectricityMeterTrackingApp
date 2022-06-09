<?php

namespace App\Http\Livewire;

use DB;
use App\Models\Meter;
use Livewire\Component;
use App\Models\Consumer;
use App\Models\Consumption;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Http\Controllers\InvoiceController;

class MetersTable extends Component
{
    use WithPagination;

    //Default number of rows when rendered
    public $perPage = 10;

    //my search bar (empty by default)
    public $search = '';

    //ordering the contents
    // public $orderBy = 'MeterID';
    // public $orderAsc = true;
    // public $ConsumptionID;
    // public $ConsumerID ;
    // public $Date;
    // public $consumerPointer;
    // public $BuildingName;
    // public $MeterNumber;
    // public $TotalVolume;
    // public $TotalUnits;
    // public $PrincipleAmount;
    // public $PrincipleAmountExclVat;
    // public $VAT;
    // public $ArrearsAmount;
    // public $TarrifIndex;
    public $MeterID;
    public $ConsumerName;

    protected $listeners = [
        'getMeterIdInput'
   ];
    //
    public function getMeterIdInput($value)
    {
        if (!is_null($value)) {
            $this->MeterID = $value;
        }
    }
    protected $rules =[
            'ConsumerName' => 'required|string',
            'MeterID' => 'required'
        ];
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
        session()->flash('message', 'Added Successfully');

        //$this->resetInputFields();
        return redirect('/home');
    }

    public function updateConsumer()
    {
        $this->validate();
        //$validatedData = $this->validate();
        //dd(7); WOW OKEY I SEE...
        //INSERT THE CONSUMER NAME (IN ITS TABLE)

        $consumer = Consumer::where('ConsumerName', '=', $this->ConsumerName)->first();
        if ($consumer) {
            $meter = Meter::where('id', '=', $this->MeterID)->first();
            $meter->consumer_id = $consumer->id;
            $meter->update();
        }
        return redirect('/home');
    }


    public function deleteStudent(int $id)
    {
        $this->id = $id;
    }

    public function destroyConsumer($id)
    {
        Consumer::where('id', $id)->delete();
        session()->flash('message', 'Deleted Successfully');
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
        $consumptions = Consumption::with('meter')
        ->paginate(5);

        foreach ($consumptions as $consumption) {
            $consumer = Consumer::where('id', '=', $consumption->meter->consumer_id)->first();
            if ($consumer != null) {
                $consumption->ConsumerName = $consumer->ConsumerName;
                $consumption->consumerId =  $consumption->meter->consumer_id;
            }
        }
        //passing a parameter for the for table for loop to the view via the controller
        return view('livewire.meters-table', [
            'consumptions' =>  $consumptions
                //->where('ConsumerName','LIKE','UNALLOCATED')
                //->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                //->simplePaginate($this->perPage),*/
        ]);
    }
}
