<table class="table-auto w-full mb-6">
    @foreach ($invoices as $invoice)
        <h4>Consumer Name: {{ $invoice->ConsumerName }}</h4>
        <thead>
            <tr>
                <th class="px-4 py-2">Meter ID</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Building Name</th>
                <th class="px-4 py-2">Meter Number</th>
                <th class="px-4 py-2">Total Volume</th>
                <th class="px-4 py-2">Total Units</th>
                <th class="px-4 py-2">Principle Amount</th>
                <th class="px-4 py-2">Amt Excl Vat</th>
                <th class="px-4 py-2">VAT</th>
                <th class="px-4 py-2">Arrears Amount</th>
                <th class="px-4 py-2">Tarriff Index</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->meters as $meter)
                <tr>
                    <td class="border px-4 py-2">{{ $meter->id }}</td>
                    <td class="border px-4 py-2">{{ $meter->Date }}</td>
                    <td class="border px-4 py-2">{{ $meter->BuildingName }}</td>
                    <td class="border px-4 py-2">{{ $meter->MeterNumber }}</td>
                    <td class="border px-4 py-2">{{ $meter->TotalVolume }}</td>
                    <td class="border px-4 py-2">{{ $meter->TotalUnits }}</td>
                    <td class="border px-4 py-2">{{ $meter->PrincipleAmount }}</td>
                    <td class="border px-4 py-2">{{ $meter->PrincipleAmountExclVat }}</td>
                    <td class="border px-4 py-2">{{ $meter->VAT }}</td>
                    <td class="border px-4 py-2">{{ $meter->ArrearsAmount }}</td>
                    <td class="border px-4 py-2">{{ $meter->TarrifIndex }}</td>
                </tr>
            @endforeach

        </tbody>
    @endforeach
</table>
<table class="table-auto w-full mt-6 py-4">
    <h4>Unallocated</h4>
    <thead>
        <tr>
            <th class="px-4 py-2">Meter ID</th>
            <th class="px-4 py-2">Date</th>
            <th class="px-4 py-2">Building Name</th>
            <th class="px-4 py-2">Meter Number</th>
            <th class="px-4 py-2">Total Volume</th>
            <th class="px-4 py-2">Total Units</th>
            <th class="px-4 py-2">Principle Amount</th>
            <th class="px-4 py-2">Amt Excl Vat</th>
            <th class="px-4 py-2">VAT</th>
            <th class="px-4 py-2">Arrears Amount</th>
            <th class="px-4 py-2">Tarriff Index</th>
        </tr>
    </thead>
    @foreach ($unallocated as $unallocated)

        <tbody>
            <tr>
                <td class="border px-4 py-2">{{ $unallocated->id }}</td>
                <td class="border px-4 py-2">{{ $unallocated->Date }}</td>
                <td class="border px-4 py-2">{{ $unallocated->BuildingName }}</td>
                <td class="border px-4 py-2">{{ $unallocated->MeterNumber }}</td>
                <td class="border px-4 py-2">{{ $unallocated->TotalVolume }}</td>
                <td class="border px-4 py-2">{{ $unallocated->TotalUnits }}</td>
                <td class="border px-4 py-2">{{ $unallocated->PrincipleAmount }}</td>
                <td class="border px-4 py-2">{{ $unallocated->PrincipleAmountExclVat }}</td>
                <td class="border px-4 py-2">{{ $unallocated->VAT }}</td>
                <td class="border px-4 py-2">{{ $unallocated->ArrearsAmount }}</td>
                <td class="border px-4 py-2">{{ $unallocated->TarrifIndex }}</td>
            </tr>
        </tbody>
    @endforeach
</table>
