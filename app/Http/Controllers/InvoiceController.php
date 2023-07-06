<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreFactureRequest;
use App\Http\Requests\UpdateFactureRequest;

class InvoiceController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $invoices = Invoice::with('customer')
            ->withCount(['courses as total' => function($query){
                $query->select(DB::raw('SUM(nombre_heures * taux_horaire)'));
        }])->get();

        return view('invoice.index')->with(['invoices' => $invoices]);
    }

    /**
     * @return View
     */
    public function create()
    {
        $customers = Customer::all();

        return view('invoice.create')->with(['customers' => $customers]);
    }

    /**
     * @param StoreFactureRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFactureRequest $request)
    {
        Invoice::create([
            'client_id' => $request->client_id,
            'payee' => 0
        ]);

        return redirect()->route('invoice.index');
    }

    /**
     * @param Invoice $invoice
     * @return View
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('courses');

        $total_hours = $invoice->courses->where('pack_heures', false)->sum('nombre_heures');
        $total_invoice = $invoice->courses->sum('total_price');

        return view('invoice.show')->with([
            'invoice' => $invoice,
            'total_hours' => $total_hours,
            'total_invoice' => $total_invoice,
        ]);
    }

    /**
     * @param Invoice $invoice
     * @return View
     */
    public function edit(Invoice $invoice)
    {
        return view('invoice.edit')->with(['invoive' => $invoice]);
    }

    /**
     * @param UpdateFactureRequest $request
     * @param Invoice $facture
     * @return RedirectResponse
     */
    public function update(UpdateFactureRequest $request, Invoice $invoice)
    {
        invoice->update([
            'payee' => $request->payee,
        ]);

        return redirect()->route('invoice.index');
    }
}
