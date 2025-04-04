<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    // login
    public function login(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required'
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Dobrodošli, ' . Auth::user()->name . ' ');
        }

        return back()->withErrors([
            'name' => 'Prijava nije uspješna. Bolje se potrudi!',
        ]);
    }

    // logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

     // Prikaz registracijske forme
     public function showRegistrationForm()
     {
         return view('auth.register');
     }
 
     // Obrada registracije
    public function register(Request $request)
    {
        // Validacija ulaznih podataka
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|max:255',
        ]);

        // Kreiranje novog korisnika
       $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->name,
            'password' => Hash::make($request->password), // Lozinka se hashira ovde
            'role_id' => 2, // Podrazumevana rola
        ]);

        // Automatsko prijavljivanje nakon registracije
        Auth::login($user);

        // Redirekcija na početnu stranicu
        return redirect()->route('home')->with('success', 'Registracija uspješna! Dobrodošli, ' . $user->name . '!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
