@extends('layouts.auth')

@section('title', 'Register - Acadelibrary')

@section('content')

<div
    class="relative z-10 w-full max-w-[1000px] bg-[#0A0A0A] border-2 border-white flex flex-col md:flex-row items-stretch shadow-[0_0_5px_rgba(0,0,0,0.5)] min-h-[700px]">

    <!-- Kolom Kiri: Bookshelf Image (Di halaman Register pindah ke kiri) -->
    <!-- Menggunakan pl-4 agar ada jarak hitam di sebelah kiri bingkai -->
    <div class="hidden md:flex w-[560px] shrink-0 pl-4 py-5">
        <div class="relative rounded-[5px] border border-white overflow-hidden w-full h-full">
            <!-- Tambahkan object-cover agar gambar tidak gepeng -->
            <img src="{{ asset('images/artisticbookshelf.webp') }}" class="w-full h-full opacity-50 object-cover"
                alt="Artistic Bookshelf Image">
        </div>
    </div>

    <!-- Kolom Kanan: Form Register -->
    <div class="flex-1 flex flex-col justify-center px-12 py-12">

        <h1 class="font-serif text-[40px] text-white leading-tight mb-1">
            Become a Member
        </h1>
        <p class="font-sans text-[15px] text-[#8d8d8d] mb-6">
            Please fill in your details to create your account.
        </p>

        <button
            class="w-full bg-white text-black font-sans font-medium text-[15px] py-2.5 flex items-center justify-center gap-3 hover:bg-gray-200 transition-colors duration-300">
            <img src="{{ asset('images/icons/GoogleIcon.webp') }}" class="w-auto h-5" alt="Google">
            Continue With Google
        </button>

        <div class="flex items-center gap-4 my-5">
            <div class="flex-grow border-t border-[#ffffff]"></div>
            <span class="text-[#ffffff] text-[15px] font-sans">or</span>
            <div class="flex-grow border-t border-[#ffffff]"></div>
        </div>

        <form action="{{ route('register') }}" method="POST" class="flex flex-col w-full">
            @csrf

            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-500/20 border border-red-500 rounded text-red-200 text-sm">
                @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <!-- Full Name -->
            <div class="mb-3.5">
                <label for="name" class="block font-sans text-[15px] text-gray-300 mb-1.5">Full Name</label>
                <input type="text" id="name" name="name" spellcheck="false"
                    placeholder="Enter your full name"
                    value="{{ old('name') }}"
                    class="w-full bg-transparent border border-[#444444] text-white text-[14px] px-4 py-2.5 placeholder-[#666666] focus:border-white focus:ring-1 focus:ring-white focus:outline-none transition-all @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block font-sans text-[15px] text-gray-300 mb-2">
                    Email
                </label>

                <input type="email" id="email" name="email" autocomplete="email" spellcheck="false"
                    placeholder="Enter your email"
                    value="{{ old('email') }}"
                    class="w-full bg-transparent border border-[#444444] text-white text-[14px] px-4 py-2.5 placeholder-[#666666] focus:border-white focus:ring-1 focus:ring-white focus:outline-none transition-all @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3.5">
                <label for="password" class="block font-sans text-[15px] text-gray-300 mb-1.5">
                    Password
                </label>

                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="w-full bg-transparent border border-[#444444] text-white text-[14px] px-4 py-2.5 pr-10 placeholder-[#666666] focus:border-white focus:ring-1 focus:ring-white focus:outline-none transition-all @error('password') border-red-500 @enderror">

                    <button type="button"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-white transition-colors toggle-password"
                        data-target="password" data-icon="icon-password">

                        <img id="icon-password" src="{{ asset('images/icons/HidePassword.webp') }}"
                            class="w-auto h-4 transition duration-200 brightness-75 hover:brightness-0 hover:invert"
                            alt="Toggle Password">
                    </button>
                </div>
                @error('password')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="password_confirmation" class="block font-sans text-[15px] text-gray-300 mb-1.5">
                    Confirm Password
                </label>

                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm your password"
                        class="w-full bg-transparent border border-[#444444] text-white text-[14px] px-4 py-2.5 pr-10 placeholder-[#666666] focus:border-white focus:ring-1 focus:ring-white focus:outline-none transition-all @error('password_confirmation') border-red-500 @enderror">

                    <button type="button"
                        class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-white transition-colors toggle-password"
                        data-target="password_confirmation" data-icon="icon-confirm">

                        <img id="icon-confirm" src="{{ asset('images/icons/HidePassword.webp') }}"
                            class="w-auto h-4 transition duration-200 brightness-75 hover:brightness-0 hover:invert"
                            alt="Toggle Password">
                    </button>
                </div>
                @error('password_confirmation')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit"
                class="w-full bg-white text-black font-sans font-medium text-[15px] py-2.5 hover:bg-gray-200 transition-colors mb-3">
                Register
            </button>

            <!-- Login Link -->
            <p class="text-center text-[15px] text-[#888888] font-sans">
                Already have an account? <a href="/login"
                    class="text-[#ffffff] hover:underline transition-all">Login</a>
            </p>
        </form>
    </div>

</div>
@endsection