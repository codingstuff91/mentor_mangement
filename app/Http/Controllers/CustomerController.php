<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $customers = Customer::all();

        return view('customer.index')->with(['customers' => $customers]);
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('customer.create');
    }


    /**
     * @param StoreCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCustomerRequest $request)
    {
        Customer::create([
            'nom' => $request->nom,
            'commentaires' => $request->commentaires
        ]);

        return redirect()->route('customer.index');
    }


    /**
     * @param Customer $customer
     * @return View
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit')->with(['customer' => $customer]);
    }


    /**
     * @param UpdateCustomerRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer = Customer::find($customer->id);
        $customer->nom = $request->nom;
        $customer->commentaires = $request->commentaires;

        $customer->save();

        return redirect()->route('customer.index');
    }


    /**
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index');
    }
}
