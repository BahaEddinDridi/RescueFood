<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | Register Controller
    |----------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,donateur,beneficiaire,transporteur'],
            'phone_number' => ['required', 'string'],
            'birthdate' => ['required', 'date'],
            'sector' => ['required', 'in:restaurant,grocery_store,food_bank,food_delivery,catering,food_association'],
            'association_name' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'phone_number' => $data['phone_number'],
            'birthdate' => $data['birthdate'],
            'sector' => $data['sector'],
            'association_name' => $data['association_name'] ?? null,
            'city' => $data['city'] ?? null,
        ]);
        User::where('role', 'admin')->get()->each(function ($admin) use ($user) {
            $admin->notifications()->create([
                'titre' => 'Nouvel utilisateur inscrit',
                'message' => 'Un nouvel utilisateur s\'est inscrit : ' . $user->first_name . ' ' . $user->last_name,
                'type' => 'new_registration',
                'est_vu' => false,
            ]);
        });
        return $user;
    }
}
