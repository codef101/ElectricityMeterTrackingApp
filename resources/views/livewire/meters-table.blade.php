<div>
    <div>
        <button class="tablink" onclick="openPage('Home', this, 'grey')">Import CSV File</button>
        <button class="tablink" onclick="openPage('News', this, 'grey')" id="defaultOpen">View
            Un-Allocated</button>
        <button class="tablink" onclick="openPage('Contact', this, 'grey')">Consumer Control</button>
        <!--<button class="tablink" onclick="openPage('About', this, 'grey')">About</button>-->

        <div id="Home" class="tabcontent">
            <form action="{{ route('excel-import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Import User Data</button>
            </form>
        </div>

        <div id="News" class="tabcontent">
            <div style="margin-bottom: 15px">
                <button type="button" class="btn btn-success" onclick="window.location='{{ url('invoice') }}'"
                    target="_blank">View All Invoice Totals (PDF Format)</button>
                <button type="button" class="btn btn-success"
                    onclick="window.location='{{ url('csv-export') }}'">Export in CSV Format</button>
            </div>

            <table class="table-auto w-full mb-6">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Meter ID</th>
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
                    @foreach ($consumptions as $consumption)
                        <tr>
                            <td class="border px-4 py-2">{{ $consumption->id }}</td>
                            <td class="border px-4 py-2">{{ $consumption->Date }}</td>
                            <td class="border px-4 py-2">{{ $consumption->BuildingName }}</td>
                            <td class="border px-4 py-2">
                                @if ($consumption->ConsumerName == null)
                                    UNALLOCATED
                                @else
                                    {{ $consumption->ConsumerName }}
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $consumption->meter->MeterNumber }}</td>
                            <td class="border px-4 py-2">{{ $consumption->TotalVolume }}</td>
                            <td class="border px-4 py-2">{{ $consumption->TotalUnits }}</td>
                            <td class="border px-4 py-2">{{ $consumption->PrincipleAmount }}</td>
                            <td class="border px-4 py-2">{{ $consumption->PrincipleAmountExclVat }}</td>
                            <td class="border px-4 py-2">{{ $consumption->VAT }}</td>
                            <td class="border px-4 py-2">{{ $consumption->ArrearsAmount }}</td>
                            <td class="border px-4 py-2">{{ $consumption->TarrifIndex }}</td>

                            <td class="border d-flex">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#updateStudentModal" data-meter-id="{{$consumption->meter->id}}"
                                     class="btn btn-primary btn-sm">Allocate
                                    Consumer</button>
                                    <a href="{{ url('customer-invoice/'.$consumption->consumerId)}}"
                                        class="btn btn-secondary btn-sm">Get Invoice
                                    </a>
                                <!--<button type="button" data-bs-toggle="modal" data-bs-target="#deleteStudentModal" wire:click="deleteStudent({{ $consumption->id }})" class="btn btn-danger"> Delete</button>

                                <button type="button" onclick="window.location='{{ url("SpecificInvoice/ $consumption->MeterID ") }}'"  class="btn btn-secondary"> Download Invoice</button> -->

                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div id="Contact" class="tabcontent">
            <!--NEED TO HAVE A TABLE FOR CONSUMER CRUD (ADDING,DELETING,EDITING)-->

            <div>
                <form>
                    <div class="form-group">
                        <input style="width: 50%;margin: auto;" type="text" class="form-control"
                            placeholder="Enter Consumer Name to Save" wire:model="ConsumerName">

                        <button style="margin-top: 10px" wire:click.prevent="storeConsumer()"
                            class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
            <div>
                <table class="table mt-8" style="width: 40%;margin: auto;margin-top:20px">
                    <thead>
                        <tr>

                            <th>Consumer Name</th>
                            <!--<th>Meter Number</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consumerPointer as $value)
                            <tr>

                                <td>{{ $value->ConsumerName }}</td>
                                <!--<td>{{ $value->consumption }}</td>-->
                                <td>
                                    <!--<button  wire:click="update({{ $value->id }})" class="btn btn-primary btn-sm">Save Edit(Not working yet, i want a possible inline edit)</button>-->
                                    <button wire:click="destroyConsumer({{ $value->id }})"
                                        class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="About" class="tabcontent">
            <h3>About</h3>
            <p>Who we are and what we do.</p>
        </div>
        <!--<div class="w-full flex pb-10">

            <div class="w-3/6 mx-1">
                <input wire:model.debounce.200ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search by Date or Building Name or Consumer or Meter Number">
            </div>
            <div class="w-1/6 relative mx-1">
                <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                    <option value="Date">Date</option>
                    <option value="BuildingName">Building Name</option>
                    <option value="ConsumerName">Consumer</option>
                    <option value="consumption">Meter Number</option>
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
        </div> -->

    </div>
    <!-- Insert Modal -->
    <div wire:ignore.self class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Add a New Consumer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
                </div>

                <form wire:submit.prevent="saveStudent">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Consumer Name</label>
                            <input type="text" wire:model="ConsumerName" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Update Student Modal -->
    <div wire:ignore.self class="modal fade" id="updateStudentModal" tabindex="-1"
        aria-labelledby="updateStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStudentModalLabel">Allocate Consumer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="updateConsumer">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Assign a Consumer</label>
                            <select wire:model="ConsumerName" class="form-control">
                                <option>---Choose a consumer from the drop down---</option>
                                @foreach ($consumers as $item)
                                    <option>{{ $item->ConsumerName }}</option>
                                @endforeach
                            </select>
                            @error('ConsumerName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <input wire:model="MeterID" type="hidden" id="meterId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-bs-dismiss="modal">Close</button>
                        <button wire.click="update" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Delete Student Modal -->
    <div wire:ignore.self class="modal fade" id="deleteStudentModal" tabindex="-1"
        aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStudentModalLabel">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="destroyStudent">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this data ?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yes! Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
