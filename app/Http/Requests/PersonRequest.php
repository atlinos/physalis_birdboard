<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
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
            'name' => 'sometimes|required',
            'firstname' => 'sometimes|required',
            'birthdate' => 'sometimes|nullable|date',
            'death_date' => 'sometimes|nullable|date|after_or_equal:birthdate',
            'death_age' => 'sometimes|nullable|numeric|gte:0',
            'notes' => 'sometimes|min:3'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est obligatoire',
            'firstname.required' => 'Le prénom est obligatoire',
            'birthdate.date' => 'La date de naissance doit être une date valide',
            'death_date.date' => 'La date de décès doit être une date valide',
            'death_date.after_or_equal' => 'La date de décès doit être supérieure ou égale à la date de naissance',
            'death_age.numeric' => 'L\'âge du décès doit être un nombre entier',
            'death_age.gte' => 'L\'âge du décès doit être supérieur ou égal à 0',
            'notes.min' => 'Les notes doivent au moins faire 3 caractères.'
        ];
    }
}
