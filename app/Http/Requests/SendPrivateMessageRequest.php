<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendPrivateMessageRequest extends FormRequest
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
            'subject' => 'required|string|min:3',
            'body' => 'required|string|min:3',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'Veuillez renseigner un sujet',
            'subject.min' => 'Le sujet doit être d\'au moins 3 caractères',
            'body.required' => 'Veuillez entrer un message',
            'body.min' => 'Votre message doit être d\'au moins 3 caractères',
        ];
    }
}
