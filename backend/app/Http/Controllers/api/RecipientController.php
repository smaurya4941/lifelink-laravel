<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RecipientProfile;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->is_recipient) {
            return response()->json(RecipientProfile::where('user_id', $request->user()->id)->get());
        }

        return response()->json(RecipientProfile::with('user')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'medical_condition' => ['nullable', 'string'],
            'emergency_contact' => ['required', 'string'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'weight' => ['nullable', 'integer', 'min:1', 'max:300'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'pincode' => ['nullable', 'string'],
        ]);

        $data['user_id'] = $request->user()->id;

        $profile = RecipientProfile::create($data);

        $request->user()->update(['is_recipient' => true]);

        return response()->json($profile, 201);
    }

    public function update(Request $request, RecipientProfile $recipient)
    {
        if ($recipient->user_id !== $request->user()->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'medical_condition' => ['nullable', 'string'],
            'emergency_contact' => ['required', 'string'],
            'blood_group' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'age' => ['nullable', 'integer', 'min:1', 'max:120'],
            'weight' => ['nullable', 'integer', 'min:1', 'max:300'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'pincode' => ['nullable', 'string'],
        ]);

        $recipient->update($data);

        return response()->json($recipient);
    }
}
