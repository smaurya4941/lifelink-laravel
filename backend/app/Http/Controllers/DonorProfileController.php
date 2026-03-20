<?php

namespace App\Http\Controllers;

use App\Models\DonorProfile;
use Illuminate\Http\Request;

class DonorProfileController extends Controller
{
    public function edit(Request $request)
    {
        $profile = DonorProfile::firstOrNew(['user_id' => $request->user()->id]);

        return view('donor.profile', [
            'profile' => $profile,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['required', 'integer', 'min:18', 'max:65'],
            'weight' => ['required', 'integer', 'min:45', 'max:200'],
            'height' => ['nullable', 'integer', 'min:120', 'max:220'],
            'medical_conditions' => ['nullable', 'string', 'max:1000'],
            'emergency_contact' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'last_donation_date' => ['nullable', 'date'],
            'availability_status' => ['sometimes', 'boolean'],
            'is_live_location_enabled' => ['sometimes', 'boolean'],
            'current_latitude' => ['nullable', 'numeric'],
            'current_longitude' => ['nullable', 'numeric'],
        ]);

        $data['availability_status'] = $request->boolean('availability_status');
        $data['is_live_location_enabled'] = $request->boolean('is_live_location_enabled');

        DonorProfile::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return redirect()->route('donor.profile.edit')->with('status', 'Donor profile updated.');
    }

    public function matches(Request $request)
    {
        $matches = $request->user()->donorMatches()
            ->with('bloodRequest')
            ->latest()
            ->get();

        return view('donor.matches', [
            'matches' => $matches,
        ]);
    }
}
