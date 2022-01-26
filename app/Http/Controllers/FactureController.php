<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreFactureRequest;
use App\Http\Requests\UpdateFactureRequest;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factures = Facture::with('client')->withCount(['cours as total' => function($query){
            $query->select(DB::raw('SUM(nombre_heures * taux_horaire)'));
        }])->get();

        return view('facture.index')->with(['factures' => $factures]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('facture.create')->with(['clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFactureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFactureRequest $request)
    {
        Facture::create([
            'client_id' => $request->client_id,
            'payee' => 0
        ]);

        return redirect()->route('facture.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function show(Facture $facture)
    {
        $cours = $facture->cours()->get();
        $total_heures = 0;
        $total_facture = 0;

        foreach ($cours as $lecon) {
            // Ne pas prendre en compte les heures de type PACK pour le décompte des heures
            if(!$lecon->pack_heures)
            {
                $total_heures += $lecon->nombre_heures;
            }
            $total_facture += $lecon->total_prix;
        }

        return view('facture.show')->with([
            'facture' => $facture,
            'cours' => $cours,
            'total_heures' => $total_heures,
            'total_facture' => $total_facture
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function edit(Facture $facture)
    {
        return view('facture.edit')->with(['facture' => $facture]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFactureRequest  $request
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFactureRequest $request, Facture $facture)
    {
        $facture = Facture::find($facture->id);

        $facture->payee = $request->payee;
        $facture->save();

        return redirect()->route('facture.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facture  $facture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facture $facture)
    {
        //
    }
}
