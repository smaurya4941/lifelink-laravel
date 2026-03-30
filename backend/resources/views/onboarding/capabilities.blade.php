<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Set Up Your LifeLink Experience</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('onboarding.capabilities.update') }}" class="bg-white shadow sm:rounded-lg p-6 space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <p class="text-sm text-slate-600">Choose how you want to use LifeLink. You can update this anytime in your profile.</p>
                </div>

                <div class="space-y-3">
                    <label class="flex items-start gap-3 rounded-lg border border-slate-200 p-4">
                        <input type="checkbox" name="is_donor" value="1" class="mt-1 rounded border-slate-300 text-rose-600 focus:ring-rose-200" @checked(old('is_donor', $user->is_donor))>
                        <span>
                            <span class="block text-sm font-semibold text-slate-900">I want to donate blood</span>
                            <span class="block text-xs text-slate-500">You will be visible for matching and can accept donation requests.</span>
                        </span>
                    </label>

                    <label class="flex items-start gap-3 rounded-lg border border-slate-200 p-4">
                        <input type="checkbox" name="is_recipient" value="1" class="mt-1 rounded border-slate-300 text-rose-600 focus:ring-rose-200" @checked(old('is_recipient', $user->is_recipient))>
                        <span>
                            <span class="block text-sm font-semibold text-slate-900">I may need blood requests</span>
                            <span class="block text-xs text-slate-500">You can create blood requests and track donor matches.</span>
                        </span>
                    </label>
                </div>

                @error('is_donor')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="flex items-center justify-between">
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-slate-600 hover:text-slate-700">Skip for now</a>

                    <x-primary-button>
                        Continue
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

