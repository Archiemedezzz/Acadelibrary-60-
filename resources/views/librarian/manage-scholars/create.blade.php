@extends('layouts.librarian')

@section('title', 'Add New Scholar - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <div
            class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[#6B7280] text-sm uppercase tracking-[0.2em] mb-2">Add New Scholar</p>
                <h1 class="text-[28px] font-bold text-[#111827]">Create a new member account</h1>
                <p class="text-[#4B5563] mt-1">Add scholar details and account credentials for library access.</p>
            </div>
            <a href="{{ route('librarian.manage-scholars') }}"
                class="inline-flex items-center gap-2 border border-[#D1D5DB] bg-[#F3F4F6] text-[#374151] px-4 py-2 rounded-[8px] hover:bg-white">
                Back to scholar list
            </a>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6">
            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <form action="{{ route('librarian.manage-scholars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-[16px] font-medium text-[#374151] mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-[16px] font-medium text-[#374151] mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-[16px] font-medium text-[#374151] mb-2">Password</label>
                            <input type="password" name="password" id="password" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-[16px] font-medium text-[#374151] mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('password_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-[16px] font-medium text-[#374151] mb-2">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="avatar" class="block text-[16px] font-medium text-[#374151] mb-2">Avatar</label>
                            <input type="file" name="avatar" id="avatar" accept="image/*"
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('avatar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="address" class="block text-[16px] font-medium text-[#374151] mb-2">Address</label>
                        <textarea name="address" id="address" rows="5"
                            class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 mt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('librarian.manage-scholars') }}"
                            class="inline-flex items-center justify-center bg-gray-500 text-white px-5 py-2 rounded-[8px] hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="inline-flex items-center justify-center bg-black text-white px-5 py-2 rounded-[8px] hover:bg-[#111111]">Add
                            Scholar</button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <div class="rounded-[10px] border border-[#E5E7EB] mb-5 p-10 text-center bg-[#F9FAFB]">
                    <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Scholar Avatar</p>
                    <p class="text-[#4B5563]">Upload an avatar to personalize the member profile.</p>
                </div>
                <div class="space-y-4">
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-4">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Notes</p>
                        <ul class="list-disc list-inside text-[#4B5563] text-sm space-y-2">
                            <li>Use valid email for scholar account login.</li>
                            <li>Password must be at least 8 characters.</li>
                            <li>Phone and address are optional but helpful.</li>
                        </ul>
                    </div>
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-4">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Reminder</p>
                        <p class="text-[#4B5563] text-sm">Scholar profiles can be edited later if details change.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
