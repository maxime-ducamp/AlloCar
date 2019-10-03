<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\UserCreatedNotification;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

//    /**
//     * Where to redirect users after registration.
//     *
//     * @var string
//     */
//    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'name.required' => 'Veuillez entrer un nom',
            'name.max' => 'Ce nom est trop long!',
            'name.unique' => "Ce nom d'utilisateur est déjà pris!",
            'email.required' => 'Veuillez entrer une adresse e-mail valide',
            'email.unique' => 'Un compte correspond à cette adresse est déjà enregistré.',
            'password.required' => 'Veuillez renseigner un mot de passe.',
            'password.min' => 'Votre mot de passe doit contenir au moins 8 caractères.',
            'password.confirm' => 'Les mots de passe ne correspondent pas.',
        ];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => 'required|captcha'
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar_path' => 'user_uploads/avatars/default-avatar.png',
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $user->notify(new UserCreatedNotification($user));
    }

    public function redirectTo()
    {
        return '/';
    }
}
