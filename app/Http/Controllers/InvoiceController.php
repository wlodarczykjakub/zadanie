<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\DeleteInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;

class InvoiceController extends Controller
{

    public function index()
    {
        return view('invoice.index');
    }

    public function getAll()
    {
        return Invoice::paginate(10);
    }

    public function create(CreateInvoiceRequest $request)
    {
        $invoice = new Invoice();
        $invoice->number = $request->number;
        $invoice->nip_buyer = $request->nip_buyer;
        $invoice->nip_seller = $request->nip_seller;
        $invoice->product_name = $request->product_name;
        $invoice->net_price = $request->net_price;
        $invoice->save();

        return response('ok',200);
    }

    public function update(UpdateInvoiceRequest $request)
    {
        $invoice = Invoice::find($request->id);
        if (!empty($request->number)){
            $invoice->number = $request->number;
        }
        if (!empty($request->nip_buyer)){
            $invoice->nip_buyer = $request->nip_buyer;
        }
        if (!empty($request->nip_seller)){
            $invoice->nip_seller = $request->nip_seller;
        }
        if (!empty($request->product_name)){
            $invoice->product_name = $request->product_name;
        }
        if (!empty($request->net_price)){
            $invoice->net_price = $request->net_price;
        }

        $invoice->save();

        return response('ok',200);
    }

    public function delete(DeleteInvoiceRequest $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->delete();

        return response('ok',200);
    }
}
