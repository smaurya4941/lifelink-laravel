<?php

namespace App\Http\Controllers;

use App\Models\DonorProfile;
use App\Models\RecipientProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display unified capability-based profile form.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->hasCapability('hospital') && !$user->hasCapability('donor') && !$user->hasCapability('recipient')) {
            return redirect()->route('hospital.profile.edit');
        }

        return view('profile.edit', [
            'user' => $user,
            'donorProfile' => DonorProfile::firstOrNew(['user_id' => $user->id]),
            'recipientProfile' => RecipientProfile::firstOrNew(['user_id' => $user->id]),
        ]);
    }

    /**
     * Update unified profile + capabilities + capability profiles.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasCapability('hospital') && !$user->hasCapability('donor') && !$user->hasCapability('recipient')) {
            return redirect()
                ->route('hospital.profile.edit')
                ->with('error', 'Please update organization details in Hospital Profile.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'traditional_state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],

            'is_donor' => ['nullable', 'boolean'],
            'is_recipient' => ['nullable', 'boolean'],

            'blood_group' => ['nullable', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'weight' => ['nullable', 'integer', 'min:1', 'max:300'],
            'height' => ['nullable', 'integer', 'min:120', 'max:220'],
            'emergency_contact' => ['nullable', 'string', 'max:50'],
            'medical_conditions' => ['nullable', 'string', 'max:1000'],
            'recipient_medical_condition' => ['nullable', 'string', 'max:1000'],
            'last_donation_date' => ['nullable', 'date'],
            'availability_status' => ['nullable', 'boolean'],
            'is_live_location_enabled' => ['nullable', 'boolean'],
            'current_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'current_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $capabilityInputProvided = $request->hasAny(['is_donor', 'is_recipient']);
        $isDonor = $capabilityInputProvided ? $request->boolean('is_donor') : (bool) $user->is_donor;
        $isRecipient = $capabilityInputProvided ? $request->boolean('is_recipient') : (bool) $user->is_recipient;

        if ($capabilityInputProvided && !$isDonor && !$isRecipient) {
            return Redirect::route('profile.edit')
                ->withErrors(['is_donor' => 'Please enable at least one capability (Donor or Recipient).'])
                ->withInput();
        }

        if (($isDonor || $isRecipient) && empty($data['blood_group'])) {
            return Redirect::route('profile.edit')
                ->withErrors(['blood_group' => 'Blood group is required for donor/recipient capability.'])
                ->withInput();
        }

        if ($isDonor && (empty($data['age']) || empty($data['weight']))) {
            return Redirect::route('profile.edit')
                ->withErrors(['age' => 'Age and weight are required for donor capability.'])
                ->withInput();
        }

        if ($isRecipient && empty($data['emergency_contact'])) {
            return Redirect::route('profile.edit')
                ->withErrors(['emergency_contact' => 'Emergency contact is required for recipient capability.'])
                ->withInput();
        }

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'traditional_state' => $data['traditional_state'] ?? null,
            'pincode' => $data['pincode'] ?? null,
            'country' => $data['country'] ?? ($user->country ?? 'India'),
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'is_donor' => $isDonor,
            'is_recipient' => $isRecipient,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($isDonor) {
            DonorProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'blood_group' => $data['blood_group'],
                    'age' => $data['age'],
                    'weight' => $data['weight'],
                    'height' => $data['height'] ?? null,
                    'medical_conditions' => $data['medical_conditions'] ?? null,
                    'emergency_contact' => $data['emergency_contact'] ?? null,
                    'address' => $data['address'] ?? null,
                    'city' => $data['city'] ?? null,
                    'state' => $data['traditional_state'] ?? null,
                    'pincode' => $data['pincode'] ?? null,
                    'last_donation_date' => $data['last_donation_date'] ?? null,
                    'availability_status' => $request->boolean('availability_status'),
                    'is_live_location_enabled' => $request->boolean('is_live_location_enabled'),
                    'current_latitude' => $data['current_latitude'] ?? ($data['latitude'] ?? null),
                    'current_longitude' => $data['current_longitude'] ?? ($data['longitude'] ?? null),
                ]
            );
        }

        if ($isRecipient) {
            RecipientProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'medical_condition' => $data['recipient_medical_condition'] ?? null,
                    'emergency_contact' => $data['emergency_contact'] ?? null,
                    'blood_group' => $data['blood_group'],
                    'age' => $data['age'],
                    'weight' => $data['weight'],
                    'address' => $data['address'] ?? null,
                    'city' => $data['city'] ?? null,
                    'state' => $data['traditional_state'] ?? null,
                    'pincode' => $data['pincode'] ?? null,
                ]
            );
        }

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
