
<div>
    @include('livewire.studentmodal')
    <div class="w-full flex pb-10">
        
        <div class="w-3/6 mx-1">
            <input wire:model.debounce.200ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search by Date or Building Name or Consumer or Meter Number">
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="Date">Date</option>
                <option value="BuildingName">Building Name</option>
                <option value="Consumer">Consumer</option>
                <option value="MeterNumber">Meter Number</option>
                <option value="TotalUnits">Total Units</option>
                <option value="PrincipleAmount">Principle Amount</option>
                <option value="PrincipleAmountExclVat">Principle Amount Excl Vat</option>
                <option value="VAT">VAT</option>
                <option value="ArrearsAmount">Arrears Amount</option>
                <option value="TarrifIndex">Tarrif Index</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex MeterNumbers-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderAsc" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="1">Ascending</option>
                <option value="0">Descending</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex MeterNumbers-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="perPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option>10</option>
                <option>15</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex MeterNumbers-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
            </div>
        </div>
    </div>
    <table class="table-auto w-full mb-6">
        <thead>
            <tr>                        <th class="px-4 py-2">Meter ID</th>
                                        <th class="px-4 py-2">Date</th>
                                        <th class="px-4 py-2">Building Name</th>
                                        <th class="px-4 py-2">Consumer Name</th>
                                        <th class="px-4 py-2">Meter Number</th>
                                        <th class="px-4 py-2">Total Volume</th>
                                        <th class="px-4 py-2">Total Units</th>
                                        <th class="px-4 py-2">Principle Amount</th>
                                        <th class="px-4 py-2">Amt Excl Vat</th>
                                        <th class="px-4 py-2">VAT</th>
                                        <th class="px-4 py-2">Arrears Amount</th>
                                        <th class="px-4 py-2">Tarriff Index</th>
                                        <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meterNumbers as $MeterNumber)
                <tr>
                                        <td class="border px-4 py-2">{{ $MeterNumber->MeterID }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->Date }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->BuildingName }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->ConsumerName }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->MeterNumber }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->TotalVolume }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->TotalUnits }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->PrincipleAmount }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->PrincipleAmountExclVat }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->VAT }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->ArrearsAmount }}</td>
                                        <td class="border px-4 py-2">{{ $MeterNumber->TarrifIndex }}</td>
                                        
                                        <td class="border px-4 py-2">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#updateStudentModal" wire:click="editStudent({{ $MeterNumber->MeterID }})" class="btn btn-primary">Edit</button>
                                            
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteStudentModal" wire:click="deleteStudent({{ $MeterNumber->MeterID }})" class="btn btn-danger"> Delete</button>
                                            
                                        </td>
                                        
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- pignation -->
    {!! $meterNumbers->links() !!}
</div>
