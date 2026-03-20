<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Donation::query();
        if ($user->is_donor) {
            $query->where('donor_id', $user->id);
        } elseif ($user->is_recipient) {
            $query->where('recipient_id', $user->id);
        }

        return response()->json($query->latest()->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'match_result_id' => ['nullable', 'exists:match_results,id'],
            'donor_id' => ['required', 'exists:users,id'],
            'recipient_id' => ['required', 'exists:users,id'],
            'hospital_id' => ['nullable', 'exists:users,id'],
            'units_donated' => ['required', 'integer', 'min:1', 'max:10'],
            'donation_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'is_successful' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $donation = Donation::create($data);

        return response()->json($donation, 201);
    }

    public function show(Request $request, Donation $donation)
    {
        $user = $request->user();
        if ($user->is_donor && $donation->donor_id !== $user->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }
        if ($user->is_recipient && $donation->recipient_id !== $user->id) {
            return response()->json(['detail' => 'Forbidden'], 403);
        }

        return response()->json($donation);
    }

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'units_donated' => ['nullable', 'integer', 'min:1', 'max:10'],
            'donation_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'is_successful' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $donation->update($data);

        return response()->json($donation);
    }

    public function destroy(Request $request, Donation $donation)
    {
        $donation->delete();
        return response()->json(['detail' => 'Deleted']);
    }
}
