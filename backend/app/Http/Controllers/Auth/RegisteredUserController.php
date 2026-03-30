<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Display the hospital registration view.
     */
    public function createHospital(): View
    {
        return view('auth.register-hospital');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Keep legacy enum value for compatibility while onboarding sets capabilities.
            'role' => 'recipient',
            'is_donor' => false,
            'is_recipient' => false,
            'is_hospital' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('onboarding.capabilities.edit');
    }

    /**
     * Handle hospital registration flow.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeHospital(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:6'],
            'hospital_name' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'hospital',
            'is_donor' => false,
            'is_recipient' => false,
            'is_hospital' => true,
        ]);

        Hospital::create([
            'user_id' => $user->id,
            'hospital_name' => $request->hospital_name,
            'license_number' => $request->license_number,
            'address' => $request->address,
            'verification_status' => 'pending',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('hospital.dashboard');
    }
}
