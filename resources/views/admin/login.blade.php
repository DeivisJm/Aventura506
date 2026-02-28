@extends('layouts.app')

@section('title', __('admin.login_title'))

@php
// Hide public layout elements on authentication pages
$hideNavbar = true;
$hideFooter = true;
@endphp

@section('content')

{{-- =====================================================
   ADMIN AUTHENTICATION PAGE
   Minimal layout without public navigation
===================================================== --}}
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
                    src="{{ asset('images/logolight.png') }}"
                    data-light="{{ asset('images/logolight.png') }}"
                    data-dark="{{ asset('images/logodark.png') }}"
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

            {{-- Login Form --}}
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
                @csrf

                {{-- Email Field --}}
                <div>
                    <label class="block text-sm font-medium mb-2
                        text-gray-900 dark:text-white">
                        {{ __('admin.email') }}
                    </label>

                    <input type="email"
                        name="email"
                        required
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
                    <label class="block text-sm font-medium mb-2
                        text-gray-900 dark:text-white">
                        {{ __('admin.password') }}
                    </label>

                    <input type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-xl
                        bg-white dark:bg-transparent
                        border border-gray-300 dark:border-gray-700
                        text-black dark:text-white
                        placeholder-gray-400 dark:placeholder-gray-500
                        focus:outline-none
                        focus:border-green-600 dark:focus:border-green-400
                        transition-colors duration-300"
                        placeholder="{{ __('admin.password_placeholder') }}">
                </div>

                {{-- Submit Button --}}
                <button type="submit"
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