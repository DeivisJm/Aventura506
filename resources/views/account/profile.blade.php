@extends('layouts.app')

@section('title', __('profile.title'))

@section('content')

{{-- =====================================================
   PROFILE PAGE – HERO
===================================================== --}}
<section class="bg-white dark:bg-gray-950 pt-32 pb-20 overflow-hidden transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6 text-center">

        <span class="inline-block text-green-600 font-semibold tracking-wide uppercase text-sm
                     opacity-0 animate-hero hero-delay-1">
            {{ __('profile.hero_tag') }}
        </span>

        <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight
                   opacity-0 animate-hero hero-delay-2">
            {{ __('profile.hero_title_line_1') }}
            <span class="text-green-600">
                {{ __('profile.hero_title_highlight') }}
            </span>
            {{ __('profile.hero_title_line_2') }}
        </h1>

        <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed
                  opacity-0 animate-hero hero-delay-3">
            {{ __('profile.hero_description') }}
        </p>

    </div>
</section>

{{-- =====================================================
   PROFILE PAGE – MAIN CONTENT
===================================================== --}}
<section class="py-20 bg-transparent">
    <div class="max-w-6xl mx-auto px-6">

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">

            {{-- =====================================================
               PROFILE SUMMARY CARD
            ===================================================== --}}
            <aside class="xl:col-span-1 scroll-hero">
                <div class="profile-summary-card rounded-[2rem] overflow-hidden shadow-xl border border-gray-200 dark:border-gray-800">

                    {{-- Decorative top banner --}}
                    <div class="profile-summary-top relative">
                        <div class="profile-summary-glow"></div>
                    </div>

                    <div class="px-6 pb-7 -mt-12 relative z-10">

                        {{-- User avatar --}}
                        <div class="profile-avatar">
                            {{ strtoupper(substr($user->username ?: $user->name, 0, 1)) }}
                        </div>

                        {{-- Main identity --}}
                        <div class="mt-5">
                            <p class="text-green-600 font-semibold tracking-wide uppercase text-xs">
                                {{ __('profile.profile_badge') }}
                            </p>

                            <h2 class="mt-3 text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white break-words leading-tight">
                                {{ $user->name }}
                            </h2>

                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 break-all">
                                {{ $user->email }}
                            </p>
                        </div>

                        {{-- Quick information list --}}
                        <div class="mt-7 space-y-4">

                            <div class="profile-info-box">
                                <p class="profile-info-label">
                                    {{ __('profile.name') }}
                                </p>
                                <p class="profile-info-value break-words">
                                    {{ $user->name }}
                                </p>
                            </div>

                            <div class="profile-info-box">
                                <p class="profile-info-label">
                                    {{ __('profile.username') }}
                                </p>
                                <p class="profile-info-value break-all">
                                    {{ $user->username ?: __('profile.not_registered') }}
                                </p>
                            </div>

                            <div class="profile-info-box">
                                <p class="profile-info-label">
                                    {{ __('profile.email') }}
                                </p>
                                <p class="profile-info-value break-all">
                                    {{ $user->email }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </aside>

            {{-- =====================================================
               PROFILE FORM CARD
            ===================================================== --}}
            <div class="xl:col-span-2 scroll-hero">
                <div class="profile-form-card rounded-[2rem] overflow-hidden shadow-xl border border-gray-200 dark:border-gray-800">

                    {{-- Form header --}}
                    <div class="px-6 md:px-8 pt-8 pb-6 border-b border-gray-200 dark:border-gray-800">
                        <span class="text-green-600 font-semibold tracking-wide uppercase text-sm">
                            {{ __('profile.form_tag') }}
                        </span>

                        <h2 class="mt-3 text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                            {{ __('profile.form_title') }}
                        </h2>

                        <p class="mt-4 text-gray-600 dark:text-gray-400 max-w-2xl leading-relaxed">
                            {{ __('profile.form_description') }}
                        </p>
                    </div>
                    
                    @if(session('success'))
                    <div class="mx-6 md:mx-8 mt-8 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('account.profile.update') }}" class="px-6 md:px-8 py-8 space-y-10">
                        @csrf
                        @method('PUT')

                        {{-- =====================================================
                           BASIC INFORMATION
                        ===================================================== --}}
                        <div>
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ __('profile.basic_information_title') }}
                                </h3>

                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('profile.basic_information_description') }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        {{ __('profile.name') }}
                                    </label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        class="profile-input w-full"
                                        placeholder="{{ __('profile.name_placeholder') }}">

                                    @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Username --}}
                                <div>
                                    <label for="username" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        {{ __('profile.username') }}
                                    </label>

                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        value="{{ old('username', $user->username) }}"
                                        class="profile-input w-full"
                                        placeholder="{{ __('profile.username_placeholder') }}">

                                    @error('username')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            {{-- Email --}}
                            <div class="mt-5">
                                <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                    {{ __('profile.email') }}
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    class="profile-input w-full"
                                    placeholder="{{ __('profile.email_placeholder') }}">

                                @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- =====================================================
                           PASSWORD SECTION
                        ===================================================== --}}
                        <div>
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ __('profile.password_title') }}
                                </h3>

                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('profile.password_description') }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- New password --}}
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        {{ __('profile.new_password') }}
                                    </label>

                                    <div class="password-field">
                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            autocomplete="new-password"
                                            class="profile-input password-input w-full"
                                            placeholder="{{ __('profile.password_placeholder') }}">

                                        <button
                                            type="button"
                                            class="password-toggle"
                                            data-target="password"
                                            aria-label="{{ __('profile.password_toggle_label') }}"
                                            aria-pressed="false">

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

                                    @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Confirm password --}}
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        {{ __('profile.confirm_password') }}
                                    </label>

                                    <div class="password-field">
                                        <input
                                            type="password"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            autocomplete="new-password"
                                            class="profile-input password-input w-full"
                                            placeholder="{{ __('profile.password_placeholder') }}">

                                        <button
                                            type="button"
                                            class="password-toggle"
                                            data-target="password_confirmation"
                                            aria-label="{{ __('profile.password_toggle_confirm_label') }}"
                                            aria-pressed="false">

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

                                    @error('password_confirmation')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        {{-- =====================================================
                           ACTIONS
                        ===================================================== --}}
                        <div class="pt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('profile.save_changes_helper') }}
                            </p>

                            <button type="submit" class="btn-primary">
                                {{ __('profile.save_changes') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection