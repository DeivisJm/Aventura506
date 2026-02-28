@extends('layouts.app')

@php
$hideNavbar = true;
@endphp

@section('title', 'Admin Dashboard')

@section('content')

<section class="min-h-screen flex items-center justify-center bg-white dark:bg-gray-900">

    <div class="bg-white dark:bg-white/5 backdrop-blur-md
        rounded-3xl p-12
        border border-gray-200 dark:border-white/10
        shadow-xl text-center">

        <h1 class="text-3xl font-serif mb-4 text-gray-900 dark:text-white">
            Welcome Super Admin
        </h1>

        <p class="text-gray-600 dark:text-gray-400 mb-8">
            You are authenticated with full administrative privileges.
        </p>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="px-8 py-3 rounded-full
                bg-red-600 hover:bg-red-700
                text-white uppercase tracking-widest
                transition-all duration-300">
                Logout
            </button>
        </form>

    </div>

</section>

@endsection