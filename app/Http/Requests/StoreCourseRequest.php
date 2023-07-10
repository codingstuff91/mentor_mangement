<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'date' => 'required',
            'start_hour' => 'required',
            'end_hour' => 'required',
            'learned_notions' => 'required',
            'hourly_rate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'student.required' => 'Veuillez sélectionner un étudiant',
            'invoice.required' => 'Veuillez choisir une facture',
            'date.required' => 'Veuillez sélectionner une date',
            'start_hour.required' => 'Veuillez choisir une heure de début',
            'end_hour.required' => 'Veuillez choisir une heure de fin',
            'learned_notions.required' => 'Veuillez préciser les notions abordées durant le cours',
            'hourly_rate.required' => 'Veuillez saisir un taux horaire',
        ];
    }
}
