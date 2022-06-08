<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\NumberFormatter;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use App\Models\Consumption;
use App\Models\Consumer;
use DB;

class InvoiceController extends Controller
{
    public $id;
    public $Date;
    public $ConsumerName;
    /**
     * Display a listing of the resource. FOR SPECIFIC INVOICES
     *
     * @return \Illuminate\Http\Response
     */
    public function mount($id)
    {
        $this -> id = $id;
    }

    public function showSpecificInvoice($id)
    {
        $SpecificRow = Consumption::find($id);
        $this -> selected_id = $id;

        $client = new Party([
            'name'          => 'Electricity Suppliers',
            'phone'         => 'xxx xxx xxxx',
            'custom_fields' => [
                'Title' => 'Some info',
                'Title' => 'Some info',
            ],
        ]);

        $customer = new Party([
            'name'          => 'Consumer: '.$SpecificRow->ConsumerName,
            'address'       => $SpecificRow->BuildingName,
            'title'          => 'some info',
            'custom_fields' => [
                'Meter Number' => $SpecificRow->MeterNumber,
            ],
        ]);


        $estate = MeterNumber::all();

        $items []=
            (new InvoiceItem())
                ->title('Meter Number : '.$SpecificRow->MeterNumber)
                ->description('Used '.$SpecificRow->TotalUnits.' units')
                ->pricePerUnit($SpecificRow->PrincipleAmountExclVat)
                ->tax($SpecificRow->VAT)
                ->quantity(1)
            ;


        $notes = [
            'your multiline',
            'additional notes',
            'in regards of payments or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('invoice')
            ->series('BIG')
            ->status(__('invoices::invoice.paid'))
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('R')
            ->currencyCode('Rands')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)

            ->addItems($items)

            ->notes($notes)
            ->logo(public_path('\sptlogo-removebg-preview.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }


    /**
     * Display a listing of the resource. FOR MAIN INVOICE
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $client = new Party([
            'name'          => 'Electricity Suppliers',
            'phone'         => 'xxx xxx xxxx',
            'custom_fields' => [
                'Title' => 'Some info',
                'Title' => 'Some info',
            ],
        ]);

        $customer = new Party([
            'name'          => 'Estates',
            'address'       => 'address',
            'title'          => 'some info',
            'custom_fields' => [
                'title' => 'some info',
            ],
        ]);

        $Estates = Consumption::all();
        foreach ($Estates as $estate) {
            $items []=
            (new InvoiceItem())
                ->title('Consumer Name : '.$estate->ConsumerName)
                ->description('Meter Number : '.$estate->MeterNumber.' |  Building Name : '.$estate->BuildingName)
                ->pricePerUnit($estate->PrincipleAmountExclVat)
                ->tax($estate->VAT)
                ->quantity(1)
            ;
        }

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of payments or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('invoice')
            ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            ->status(__('invoices::invoice.paid'))
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('R')
            ->currencyCode('Rands')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)

            ->addItems($items)

            ->notes($notes)
            ->logo(public_path('\sptlogo-removebg-preview.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
