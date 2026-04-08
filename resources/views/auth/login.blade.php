@extends('layouts.auth')

@section('title', 'Login - Acadelibrary')

@section('content')
    <div
        class="relative z-10 w-full max-w-[1000px] bg-[#0A0A0A] border-2 border-white flex flex-col md:flex-row items-stretch shadow-[0_0_5px_rgba(0,0,0,0.5)] min-h-[700px]">

        <div class="flex-1 flex flex-col justify-center px-12 py-12">

            <a href="/" class="flex items-center gap-3 mb-10 group w-max">
                <img src="{{ asset('images/logos/AcadelibraryLogoWhiteGroup.webp') }}" class="w-auto h-14" alt="">
            </a>

            <h1 class="font-serif text-[40px] text-white">
                Welcome Back
            </h1>
            <p class="font-sans text-[15px] text-[#8d8d8d] mb-6">
                Please log in with your account to continue
            </p>

            <button
                class="w-full bg-white text-black font-sans font-medium text-[15px] py-2.5 flex items-center justify-center gap-3 hover:bg-gray-200 transition-colors duration-300">
                <img src="{{ asset('images/icons/GoogleIcon.webp') }}" class="w-auto h-5" alt="Google">
                Login With Google
            </button>

            <div class="flex items-center gap-4 my-6">
                <div class="flex-grow border-t border-[#ffffff]"></div>
                <span class="text-[#ffffff] text-[15px] font-sans">or</span>
                <div class="flex-grow border-t border-[#ffffff]"></div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="flex flex-col w-full">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block font-sans text-[15px] text-gray-300 mb-2">
                        Email
                    </label>

                    <input type="email" id="email" name="email" autocomplete="email" spellcheck="false"
                        placeholder="Enter your email"
                        class="w-full bg-transparent border border-[#444444] text-white text-[14px] px-4 py-2.5 placeholder-[#666666] focus:border-white focus:ring-1 focus:ring-white focus:outline-none transition-all">
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-sans text-[15px] text-gray-300 mb-2">
                        Password
                    </label>

                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            class="w-full bg-transparent border border-[#444444] text-white text-[14px] px-4 py-2.5 pr-10 placeholder-[#666666] focus:border-white focus:ring-1 focus:ring-white focus:outline-none transition-all">

                        <button type="button"
                            class="absolute inset-y-0 right-3 flex items-center text-gray-500 hover:text-white transition-colors toggle-password"
                            data-target="password" data-icon="icon-password">

                            <img id="icon-password" src="{{ asset('images/icons/HidePassword.webp') }}"
                                class="w-auto h-4 transition duration-200 brightness-75 hover:brightness-0 hover:invert"
                                alt="Toggle Password">
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2 mb-8">
                    <label class="flex items-center gap-3 cursor-pointer select-none">

                        <input type="checkbox" class="peer hidden">

                        <div
                            class="w-4 h-4 border border-[#555] rounded-smtransition-all duration-200 peer-checked:border-white relative after:absolute after:inset-1 after:bg-white after:scale-0 after:transition-transform after:duration-200 peer-checked:after:scale-100">
                        </div>

                        <span class="text-[14px] text-[#888888] transition-colors duration-200 peer-checked:text-white">
                            Remember me
                        </span>

                    </label>
                    <a href="#" class="text-[14px] text-[#888888] hover:text-white transition-colors">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-white text-black font-sans font-medium text-[15px] py-2.5 hover:bg-gray-200 transition-colors mb-3">
                    Login
                </button>

                <p class="text-center text-[15px] text-[#888888] font-sans">
                    Don't have an account? <a href="/register"
                        class="text-[#ffffff] hover:underline transition-all">Register</a>
                </p>
            </form>
        </div>

        <div class="hidden md:flex w-[560px] shrink-0 pr-4 py-5">
            <div class="relative rounded-[5px] border border-white overflow-hidden w-full h-full">
                <img src="{{ asset('images/artisticbookshelf.webp') }}" class="w-full h-full opacity-50"
                    alt="Artistic Bookshelf Image">
            </div>
        </div>
    </div>
@endsection
