<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $invoices = Invoice::with('customer')
            ->withCount(['courses as total' => function($query){
                $query->select(DB::raw('SUM(hours_count * hourly_rate)'));
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
     * @param StoreInvoiceRequest $request
     * @return RedirectResponse
     */
    public function store(StoreInvoiceRequest $request)
    {
        Invoice::create([
            'client_id' => $request->client_id,
            'paid' => 0,
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
        return view('invoice.edit')->with(['invoice' => $invoice]);
    }

    /**
     * @param Invoice $facture
     * @return RedirectResponse
     */
    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'paid' => $request->paid,
        ]);

        return redirect()->route('invoice.index');
    }
}
