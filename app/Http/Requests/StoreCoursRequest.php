<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'student' => 'required',
            'invoice' => 'required',
            'date_debut' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'notions_apprises' => 'required',
            'taux_horaire' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'student.required' => 'Veuillez sélectionner un étudiant',
            'invoice.required' => 'Veuillez choisir une facture',
            'date_debut.required' => 'Veuillez sélectionner une date',
            'heure_debut.required' => 'Veuillez choisir une heure de début',
            'heure_fin.required' => 'Veuillez choisir une heure de fin',
            'notions_apprises.required' => 'Veuillez préciser les notions abordées durant le cours',
            'taux_horaire.required' => 'Veuillez saisir un taux horaire',
        ];
    }
}
