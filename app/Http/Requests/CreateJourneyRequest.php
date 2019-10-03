<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateJourneyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure' => 'required|string',
            'arrival' => 'required|string',
            'seats' => 'required|numeric|min:1|max:7',

            'departure_date' => 'required|date_format:Y-m-d',
            'departure_hour' => 'numeric|min:1|max:24',
            'departure_minutes' => 'numeric|min:0|max:59',

            'arrival_date' => 'required|date_format:Y-m-d',
            'arrival_hour' => 'nullable|numeric|min:1|max:24',
            'arrival_minutes' => 'nullable|numeric|min:0|max:59',

            'allows_pets' => 'nullable',
            'allows_smoking' => 'nullable',
            'driver_comment' => 'nullable|max:300',
        ];
    }

    public function messages()
    {
        return [
            'departure.required' => 'Veuillez renseigner une ville de départ correcte',
            'departure.string' => 'Veuillez renseigner une ville de départ correcte',
            'arrival.required' => 'Veuille renseigner une ville d\'arrivée correcte',
            'arrival.string' => 'Veuillez renseigner une ville d\'arrivée correcte',

            'departure_date.required' => 'Veuillez renseigner une date de départ',
            'departure_date.format' => 'Le format de la date de départ est invalide',
            'depature_date.before' => "La date de départ doit être inférieure à la date d'arrivée",
            'arrival_date.required' => 'Veuillez renseigner une date d\'arrivée',
            'arrival_date.format' => 'Le format de la date d\'arrivée est invalide',

            'driver_comment.max' => 'Le commentaire ne peut pas dépasser 300 caractères',
        ];
    }
}
