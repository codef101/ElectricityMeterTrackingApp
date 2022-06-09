<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Meter;
use App\Models\Consumer;
use Barryvdh\DomPDF\PDF;
use App\Models\Consumption;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\NumberFormatter;

class InvoiceController extends Controller
{
    public $id;
    public $Date;
    public $ConsumerName;

    public function mount($id)
    {
        $this -> id = $id;
    }
    /**
    * Display a listing of the resource. FOR SPECIFIC INVOICES
    *
    * @return \Illuminate\Http\Response
    */
    public function customer_invoice($id)
    {
        $customer = Consumer::find($id);
        $meters = Meter::where('consumer_id', '=', $customer->id)->join('consumptions', 'consumptions.meter_id', '=', 'meters.id')->get();
        $items = [];
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
            'name'          => 'Consumer: '.$customer->ConsumerName,
            'address'       => '',
            'title'          => 'some info',
            'custom_fields' => [
                'Meter Number' => '',
            ],
        ]);


        foreach ($meters as $meter) {
            array_push(
                $items,
                (new InvoiceItem())
                ->title('Meter Number : '.$meter->MeterNumber)
                ->description('Used '.$meter->TotalUnits.' units')
                ->pricePerUnit($meter->PrincipleAmountExclVat)
                ->tax($meter->VAT)
                ->quantity(1)
            );
        }



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
    public function all_invoices()
    {
        $consumers = Consumer::get();
        $items = [];
        foreach ($consumers as $consumer) {
            //  Get meters and consumptions
            $meters = Meter::where('consumer_id', '=', $consumer->id)
                                ->Join('consumptions', 'consumptions.meter_id', '=', 'meters.id')->get();

            $consumer->meters = $meters;
            foreach ($meters as $meter) {
                $consumer->total += $meter->TotalVolume;
            }
        }
        $unallocated = Meter::where('consumer_id', '=', null)
                        ->Join('consumptions', 'consumptions.meter_id', '=', 'meters.id')->get();
        return view('invoices', ['invoices'=>$consumers, 'unallocated' => $unallocated]);
        return view('home');
    }
    public function export_invoices()
    {
        $consumers = Consumer::get();
        $items = [];
        foreach ($consumers as $consumer) {
            //  Get meters and consumptions
            $meters = Meter::where('consumer_id', '=', $consumer->id)
                            ->Join('consumptions', 'consumptions.meter_id', '=', 'meters.id')->get();

            $consumer->meters = $meters;
            foreach ($meters as $meter) {
                $consumer->total += $meter->TotalVolume;
            }
        }
        $unallocated = Meter::where('consumer_id', '=', null)
                    ->Join('consumptions', 'consumptions.meter_id', '=', 'meters.id')->get();
        view()->share(['invoices'=>$consumers, 'unallocated' => $unallocated]);
        $file = PDF::loadView('export-invoices', [$consumers, $unallocated]);
        return $file->download('invoices.pdf');
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
