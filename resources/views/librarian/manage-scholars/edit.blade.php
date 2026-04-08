@extends('layouts.librarian')

@section('title', 'Edit Scholar - Acadelibrary')

@section('content')
    <div class="max-w-[1600px] mx-auto w-full flex flex-col gap-6">

        <div
            class="bg-white border border-[#D1D5DB] rounded-[10px] p-6 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-[#6B7280] text-sm uppercase tracking-[0.2em] mb-2">Edit Scholar</p>
                <h1 class="text-[28px] font-bold text-[#111827]">Update member profile</h1>
                <p class="text-[#4B5563] mt-1">Change scholar details, password, or avatar information.</p>
            </div>
            <a href="{{ route('librarian.manage-scholars') }}"
                class="inline-flex items-center gap-2 border border-[#D1D5DB] bg-[#F3F4F6] text-[#374151] px-4 py-2 rounded-[8px] hover:bg-white">
                Back to scholar list
            </a>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6">
            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <form action="{{ route('librarian.manage-scholars.update', $scholar) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-[16px] font-medium text-[#374151] mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $scholar->name) }}"
                                required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-[16px] font-medium text-[#374151] mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $scholar->email) }}"
                                required
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-[16px] font-medium text-[#374151] mb-2">Password (leave
                                blank to keep current)</label>
                            <input type="password" name="password" id="password"
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-[16px] font-medium text-[#374151] mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">
                            @error('password_confirmation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-[16px] font-medium text-[#374151] mb-2">Phone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $scholar->phone) }}"
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
                            @if ($scholar->avatar)
                                <p class="text-sm text-gray-600 mt-1">Current: <img
                                        src="{{ asset('storage/' . $scholar->avatar) }}"
                                        class="w-10 h-10 inline rounded-full object-cover"></p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="address" class="block text-[16px] font-medium text-[#374151] mb-2">Address</label>
                        <textarea name="address" id="address" rows="5"
                            class="w-full border border-[#D1D5DB] rounded-[6px] px-3 py-2 focus:outline-none focus:ring-0 focus:border-[#000000]">{{ old('address', $scholar->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 mt-6 sm:flex-row sm:justify-end">
                        <a href="{{ route('librarian.manage-scholars') }}"
                            class="inline-flex items-center justify-center bg-gray-500 text-white px-5 py-2 rounded-[8px] hover:bg-gray-600">Cancel</a>
                        <button type="submit"
                            class="inline-flex items-center justify-center bg-black text-white px-5 py-2 rounded-[8px] hover:bg-[#111111]">Update
                            Scholar</button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-[#D1D5DB] rounded-[10px] p-6">
                <div
                    class="overflow-hidden rounded-[10px] border border-[#E5E7EB] mb-5 h-[260px] bg-[#F9FAFB] flex items-center justify-center">
                    <img src="{{ $scholar->avatar ? asset('storage/' . $scholar->avatar) : asset('images/avatar-placeholder.webp') }}"
                        alt="Current avatar" class="w-32 h-32 rounded-full object-cover">
                </div>
                <div class="space-y-4">
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-4">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Scholar status</p>
                        <p class="text-[#4B5563] text-sm">Keep scholar contact and profile details up to date.</p>
                    </div>
                    <div class="bg-[#F8FAFC] border border-[#E5E7EB] rounded-[10px] p-4">
                        <p class="text-sm uppercase tracking-[0.2em] text-[#6B7280] mb-2">Password</p>
                        <p class="text-[#4B5563] text-sm">Leave password blank if you don’t want to change it now.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
