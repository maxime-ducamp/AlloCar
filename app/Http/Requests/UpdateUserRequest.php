<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'user_avatar' => 'mimes:jpeg,bmp,png|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Veuillez entrer un nom correct',
            'email.required' => 'Veuillez entrer une adresse e-mail valide',
            'email.email' => 'Veuillez entrer une adresse e-mail valide',
            'user_avatar.mimes' => 'Ce format n\'est pas supporté',
            'user_avatar.max' => 'La taille du fichier est trop importante',
        ];
    }
}
