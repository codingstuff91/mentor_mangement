<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'date_debut' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'notions_apprises' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date_debut.required' => 'Veuillez sélectionner une date',
            'heure_debut.required' => 'Veuillez choisir une heure de début',
            'heure_fin.required' => 'Veuillez choisir une heure de fin',
            'notions_apprises.required' => 'Veuillez préciser les notions abordées durant le cours',
        ];
    }
}
