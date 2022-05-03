<?php

namespace App\Http\Livewire;

use App\Models\MeterNumber;
use Livewire\Component;
use Livewire\WithPagination;

class MetersTable extends Component
{
    use WithPagination;

    //Default number of rows when rendered
    public $perPage = 10;

    //my search bar (empty by default)
    public $search = '';

    //ordering the contents
    public $orderBy = 'id';
    public $orderAsc = true;


    //updating patch
    //editing functionality ***************************************************
    //updating
    public $Date, $BuildingName, $Consumer, $MeterNumber, $TotalVolume, $TotalUnits, $PrincipleAmount, $PrincipleAmountExclVat, $VAT, $ArrearsAmount, $TarrifIndex,$row_id;
    protected function rules()
    {
        return [
            'Date' => 'required|string',
            'BuildingName' => 'required|string',
            'Consumer' => 'required|string|min:1',
            'MeterNumber' => 'required|string',
            'TotalVolume' => 'required|string',
            'TotalUnits' => 'required|string',
            'PrincipleAmount' => 'required|string',
            'PrincipleAmountExclVat' => 'required|string',
            'VAT' => 'required|string',
            'ArrearsAmount' => 'required|string',
            'TarrifIndex' => 'required|string',
        ];
    }

    
    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function saveStudent()
    {
        $validatedData = $this->validate();

        Consumer::create($validatedData);
        session()->flash('message','Added Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function editStudent(int $row_id)
    {
        $student = MeterNumber::find($row_id);
        if($student){
            $this->row_id = $student->id;
            $this->Date = $student->Date;
            $this->BuildingName = $student->BuildingName;
            $this->Consumer = $student->Consumer;
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

    public function updateStudent()
    {
        $validatedData = $this->validate();

        MeterNumber::where('id',$this->row_id)->update([
            'Date' => $validatedData['Date'],
            'BuildingName' => $validatedData['BuildingName'],
            'Consumer' => $validatedData['Consumer'],
            'MeterNumber' => $validatedData['MeterNumber'],
            'TotalVolume' => $validatedData['TotalVolume'],
            'TotalUnits' => $validatedData['TotalUnits'],
            'PrincipleAmount' => $validatedData['PrincipleAmount'],
            'PrincipleAmountExclVat' => $validatedData['PrincipleAmountExclVat'],
            'VAT' => $validatedData['VAT'],
            'ArrearsAmount' => $validatedData['ArrearsAmount'],
            'TarrifIndex' => $validatedData['TarrifIndex']
        ]);
        session()->flash('message',' Updated Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function deleteStudent(int $row_id)
    {
        $this->id = $row_id;
    }

    public function destroyStudent()
    {
        MeterNumber::find($this->id)->delete();
        session()->flash('message','Deleted Successfully');
        $this->dispatchBrowserEvent('close-modal');
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
        //passing a parameter to the view via the controller
        return view('livewire.meters-table',[
            'meterNumbers' =>  MeterNumber::search($this->search)
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->simplePaginate($this->perPage),
        ]);
    }
}
