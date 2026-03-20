<?php

namespace App\Http\Controllers;

use App\Models\RecipientProfile;
use Illuminate\Http\Request;

class RecipientProfileController extends Controller
{
    public function edit(Request $request)
    {
        $profile = RecipientProfile::firstOrNew(['user_id' => $request->user()->id]);

        return view('recipient.profile', [
            'profile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'medical_condition' => ['nullable', 'string', 'max:1000'],
            'emergency_contact' => ['required', 'string', 'max:50'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'weight' => ['required', 'integer', 'min:1', 'max:300'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
        ]);

        RecipientProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return redirect()->route('recipient.profile.edit')->with('status', 'Recipient profile updated.');
    }
}
