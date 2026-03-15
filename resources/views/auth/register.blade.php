@extends('layouts.app')

@section('title', __('admin.register_title'))

@php
// Hide public layout elements on authentication pages
$hideNavbar = true;
$hideFooter = true;
@endphp

@section('content')

{{-- =====================================================
   ADMIN REGISTRATION PAGE
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
                    src="{{ asset('images/logos/logolight.png') }}"
                    data-light="{{ asset('images/logos/logolight.png') }}"
                    data-dark="{{ asset('images/logos/logodark.png') }}"
                    alt="Aventura506 Logo"
                    class="h-28 md:h-32 w-auto object-contain transition-all duration-300">
            </div>

            {{-- Heading --}}
            <h2 class="text-3xl font-serif text-center mb-2 text-gray-900 dark:text-white">
                {{ __('admin.register_heading') }}
            </h2>

            <p class="text-sm text-center mb-8 text-gray-600 dark:text-gray-400">
                {{ __('admin.register_subheading') }}
            </p>

            <div class="text-center mb-8">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition-colors duration-300">
                    ← Volver al inicio
                </a>
            </div>


            {{-- Registration Form --}}
            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf

                {{-- Name Field --}}
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-900 dark:text-white">
                        {{ __('admin.name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl
                        bg-white dark:bg-transparent
                        border {{ $errors->has('name') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-700' }}
                        text-black dark:text-white
                        placeholder-gray-400 dark:placeholder-gray-500
                        focus:outline-none
                        focus:border-green-600 dark:focus:border-green-400
                        transition-colors duration-300"
                        placeholder="{{ __('admin.name_placeholder') }}">

                    @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        @if($message === 'The name field is required.')
                        {{ __('admin.validation_name_required') }}
                        @else
                        {{ $message }}
                        @endif
                    </p>
                    @enderror
                </div>

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
                        class="w-full px-4 py-3 rounded-xl
                        bg-white dark:bg-transparent
                        border {{ $errors->has('email') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-700' }}
                        text-black dark:text-white
                        placeholder-gray-400 dark:placeholder-gray-500
                        focus:outline-none
                        focus:border-green-600 dark:focus:border-green-400
                        transition-colors duration-300"
                        placeholder="{{ __('admin.email_placeholder') }}">

                    @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        @if($message === 'The email field is required.')
                        {{ __('admin.validation_email_required') }}
                        @elseif($message === 'The email field must be a valid email address.')
                        {{ __('admin.validation_email_invalid') }}
                        @elseif($message === 'The email has already been taken.')
                        {{ __('admin.validation_email_unique') }}
                        @else
                        {{ $message }}
                        @endif
                    </p>
                    @enderror
                </div>

                {{-- Password Field --}}
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-900 dark:text-white">
                        {{ __('admin.password') }}
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-xl
                        bg-white dark:bg-transparent
                        border {{ $errors->has('password') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-700' }}
                        text-black dark:text-white
                        placeholder-gray-400 dark:placeholder-gray-500
                        focus:outline-none
                        focus:border-green-600 dark:focus:border-green-400
                        transition-colors duration-300"
                        placeholder="{{ __('admin.password_placeholder') }}">

                    @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        @if($message === 'The password field is required.')
                        {{ __('admin.validation_password_required') }}
                        @elseif($message === 'The password field must be at least 8 characters.')
                        {{ __('admin.validation_password_min') }}
                        @elseif($message === 'The password field confirmation does not match.')
                        {{ __('admin.validation_password_confirmed') }}
                        @else
                        {{ $message }}
                        @endif
                    </p>
                    @enderror
                </div>

                {{-- Confirm Password Field --}}
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-900 dark:text-white">
                        {{ __('admin.password_confirmation') }}
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 rounded-xl
                        bg-white dark:bg-transparent
                        border {{ $errors->has('password_confirmation') || $errors->has('password') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-700' }}
                        text-black dark:text-white
                        placeholder-gray-400 dark:placeholder-gray-500
                        focus:outline-none
                        focus:border-green-600 dark:focus:border-green-400
                        transition-colors duration-300"
                        placeholder="{{ __('admin.password_confirmation_placeholder') }}">

                    @if($errors->has('password') && $errors->first('password') === 'The password field confirmation does not match.')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        {{ __('admin.validation_password_confirmed') }}
                    </p>
                    @elseif($errors->has('password_confirmation') && $errors->first('password_confirmation') === 'The password confirmation field is required.')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                        {{ __('admin.validation_password_confirmation_required') }}
                    </p>
                    @endif
                </div>

                {{-- Back To Login --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('admin.already_have_account') }}
                        <a href="{{ route('login') }}"
                            class="font-semibold text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 transition-colors duration-300">
                            {{ __('admin.login_here') }}
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
                    {{ __('admin.register_button') }}
                </button>
            </form>

        </div>
    </div>
</section>

@endsection