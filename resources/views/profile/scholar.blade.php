@extends('layouts.scholar')
@section('title', 'Preferences - Acadelibrary')
@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('status') === 'profile-updated')
                <div class="rounded-[8px] border border-green-200 bg-green-50 p-4 text-sm text-green-800 mb-8">
                    {{ __('Profile updated successfully.') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Avatar Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-lg rounded-[12px] p-8 text-center">
                        <div
                            class="w-[120px] h-[120px] mx-auto mb-6 rounded-full bg-gray-200 border-4 border-gray-300 overflow-hidden">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/avatar-placeholder.webp') }}"
                                class="w-full h-full object-cover" alt="Avatar">
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-bold text-xl text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">Scholar | {{ $user->id_member }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-lg rounded-[12px] p-8">
                        <header class="mb-8">
                            <h2 class="font-serif text-[32px] font-bold text-gray-900 mb-2">Preferences</h2>
                            <p class="text-[16px] text-gray-600">Update your personal information and account settings.</p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Full Name</label>
                                    <input
                                        class="w-full rounded-[10px] border border-gray-300 px-4 py-3 focus:border-black focus:ring-0 transition"
                                        value="{{ old('name', $user->name) }}" name="name" type="text" required />
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Email</label>
                                    <input
                                        class="w-full rounded-[10px] border border-gray-300 px-4 py-3 focus:border-black focus:ring-0 transition"
                                        value="{{ old('email', $user->email) }}" name="email" type="email" required />
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Phone</label>
                                    <input
                                        class="w-full rounded-[10px] border border-gray-300 px-4 py-3 focus:border-black focus:ring-0 transition"
                                        value="{{ old('phone', $user->phone) }}" name="phone" type="tel" />
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Member ID</label>
                                    <input
                                        class="w-full rounded-[10px] border border-gray-300 px-4 py-3 bg-gray-100 cursor-not-allowed"
                                        value="{{ $user->id_member }}" readonly />
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Address</label>
                                    <textarea
                                        class="w-full rounded-[10px] border border-gray-300 px-4 py-3 focus:border-black focus:ring-0 transition resize-vertical"
                                        name="address" rows="4" placeholder="Enter your complete address">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-4 pt-6 border-t border-gray-200">
                                <button type="submit"
                                    class="rounded-[8px] bg-black px-8 py-3 text-sm font-semibold text-white hover:bg-gray-900 transition">
                                    Save Changes
                                </button>

                                <button type="button" onclick="document.getElementById('delete-form').submit()"
                                    class="rounded-[8px] bg-red-600 px-8 py-3 text-sm font-semibold text-white hover:bg-red-700 transition"
                                    onmouseover="this.textContent='Delete Account'; this.style.backgroundColor='#dc2626'"
                                    onmouseout="this.textContent='Danger Zone'; this.style.backgroundColor='#ef4444'">
                                    Danger Zone
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <p class="text-sm text-green-600 font-medium ml-auto">Changes saved successfully!</p>
                                @endif
                            </div>
                        </form>

                        <form id="delete-form" method="post" action="{{ route('profile.destroy') }}" class="mt-8 hidden">
                            @csrf
                            @method('delete')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
