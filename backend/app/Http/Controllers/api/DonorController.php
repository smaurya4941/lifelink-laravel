<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DonorProfile;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->is_donor) {
            return response()->json(DonorProfile::where('user_id', $request->user()->id)->get());
        }

        return response()->json(DonorProfile::with('user')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['nullable', 'integer', 'min:18', 'max:65'],
            'weight' => ['nullable', 'integer', 'min:45', 'max:200'],
            'height' => ['nullable', 'integer', 'min:120', 'max:220'],
            'medical_conditions' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'pincode' => ['nullable', 'string'],
            'last_donation_date' => ['nullable', 'date'],
        ]);

        $data['user_id'] = $request->user()->id;

        $profile = DonorProfile::create($data);

        $request->user()->update(['is_donor' => true]);

        return response()->json($profile, 201);
    }

    public function update(Request $request, DonorProfile $donor)
    {
        $data = $request->validate([
            'blood_group' => ['sometimes', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['nullable', 'integer', 'min:18', 'max:65'],
            'weight' => ['nullable', 'integer', 'min:45', 'max:200'],
            'height' => ['nullable', 'integer', 'min:120', 'max:220'],
            'medical_conditions' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'pincode' => ['nullable', 'string'],
            'last_donation_date' => ['nullable', 'date'],
            'availability_status' => ['nullable', 'boolean'],
            'is_live_location_enabled' => ['nullable', 'boolean'],
            'current_latitude' => ['nullable', 'numeric'],
            'current_longitude' => ['nullable', 'numeric'],
        ]);

        if ($donor->user_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        $donor->update($data);

        return response()->json($donor);
    }

    public function available(Request $request)
    {
        $query = DonorProfile::where('availability_status', true);

        if ($request->blood_group) {
            $query->where('blood_group', $request->blood_group);
        }
        if ($request->city) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        return response()->json($query->get());
    }
}
