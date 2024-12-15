<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Services\InvoiceService;
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
            ->withSum('courses', 'price')
            ->orderByDesc('id')
            ->paginate(10);

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
            'customer_id' => $request->customer,
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

        $total_hours = InvoiceService::compute_total_hours($invoice);
        $total_invoice = InvoiceService::compute_total_price($invoice);

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

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()->route('invoice.index');
    }
}
