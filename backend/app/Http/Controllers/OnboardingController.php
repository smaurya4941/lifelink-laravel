<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin() || $user->hasCapability('hospital')) {
            return redirect()->route('dashboard');
        }

        return view('onboarding.capabilities', [
            'user' => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'is_donor' => ['nullable', 'boolean'],
            'is_recipient' => ['nullable', 'boolean'],
        ]);

        $isDonor = (bool) ($data['is_donor'] ?? false);
        $isRecipient = (bool) ($data['is_recipient'] ?? false);

        if (!$isDonor && !$isRecipient) {
            return back()
                ->withErrors(['is_donor' => 'Please choose at least one option to continue.'])
                ->withInput();
        }

        $user = $request->user();
        $user->is_donor = $isDonor;
        $user->is_recipient = $isRecipient;
        // Maintain legacy enum role with capability model.
        $user->role = $isDonor ? 'donor' : 'recipient';
        $user->save();

        return redirect()->route('profile.edit')
            ->with('status', 'Capabilities saved. Complete your profile to start using LifeLink.');
    }
}

