@extends('layouts.app')

@section('title', __('admin.login_title'))

@php
$hideNavbar = true;
$hideFooter = true;
@endphp

@section('content')

<section class="min-h-screen flex items-center justify-center
    bg-white dark:bg-gray-900
    transition-colors duration-500">

    <div class="w-full max-w-md px-6 scroll-hero">

        {{-- Authentication Card --}}
        <div class="bg-white dark:bg-white/5 backdrop-blur-md
            rounded-3xl p-10
            border border-gray-200 dark:border-white/10
            shadow-xl transition-all duration-500">

            {{-- Brand Identity --}}
            <div class="flex justify-center mb-8">
                <img
                    src="{{ asset('images/logos/logolight.png') }}"
                    data-light="{{ asset('images/logos/logolight.png') }}"
                    data-dark="{{ asset('images/logos/logodark.png') }}"
                    alt="Aventura506 Logo"
                    class="h-28 md:h-32 w-auto object-contain transition-all duration-300">
            </div>

            {{-- Heading --}}
            <h2 class="text-3xl font-serif text-center mb-2
                text-gray-900 dark:text-white">
                {{ __('admin.login_heading') }}
            </h2>

            <p class="text-sm text-center mb-8
                text-gray-600 dark:text-gray-400">
                {{ __('admin.login_subheading') }}
            </p>

            {{-- Error Feedback --}}
            @if($errors->any())
            <div class="mb-6 text-sm text-red-600 dark:text-red-400 text-center">
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Success Feedback --}}
            @if(session('success'))
            <div class="mb-6 text-sm text-green-600 dark:text-green-400 text-center">
                {{ session('success') }}
            </div>
            @endif

            <div class="text-center mb-8">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition-colors duration-300">
                    ← {{ __('admin.back_home') }}
                </a>
            </div>

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6" autocomplete="off">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-900 dark:text-white">
                        {{ __('admin.email') }}
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl
                               bg-white dark:bg-transparent
                               border border-gray-300 dark:border-gray-700
                               text-black dark:text-white
                               placeholder-gray-400 dark:placeholder-gray-500
                               focus:outline-none
                               focus:border-green-600 dark:focus:border-green-400
                               transition-colors duration-300"
                        placeholder="{{ __('admin.email_placeholder') }}">
                </div>

                {{-- Password Field --}}
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-900 dark:text-white">
                        {{ __('admin.password') }}
                    </label>

                    <div class="password-field">
                        <input
                            type="password"
                            name="password"
                            id="login_password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-xl
                                   bg-white dark:bg-transparent
                                   border border-gray-300 dark:border-gray-700
                                   text-black dark:text-white
                                   placeholder-gray-400 dark:placeholder-gray-500
                                   focus:outline-none
                                   focus:border-green-600 dark:focus:border-green-400
                                   transition-colors duration-300
                                   password-input"
                            placeholder="{{ __('admin.password_placeholder') }}">

                        <button
                            type="button"
                            class="password-toggle"
                            data-target="login_password"
                            aria-label="Show or hide password"
                            aria-pressed="false">

                            {{-- Eye icon --}}
                            <svg class="password-icon password-icon-eye"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.438 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>

                            {{-- Eye off icon --}}
                            <svg class="password-icon password-icon-eye-off hidden"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 3l18 18" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M10.58 10.58a2 2 0 002.83 2.83" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.64 0 8.58 3.01 9.96 7.18.07.21.07.44 0 .65a10.52 10.52 0 01-4.3 5.37" />
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.23 6.23A10.48 10.48 0 002.04 11.68c-.07.2-.07.43 0 .64C3.42 16.49 7.36 19.5 12 19.5a9.8 9.8 0 004.19-.93" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Register Redirect --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('admin.no_account') }}
                        <a href="{{ route('register') }}"
                            class="font-semibold text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition-colors duration-300">
                            {{ __('admin.register_here') }}
                        </a>
                    </p>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full py-3 rounded-full
                    bg-green-600 dark:bg-green-500
                    text-white text-sm uppercase tracking-widest
                    transition-all duration-300
                    hover:bg-green-700 dark:hover:bg-green-400
                    hover:shadow-lg">
                    {{ __('admin.login_button') }}
                </button>

            </form>

        </div>

    </div>

</section>
@endsection