@extends('admin.layouts.admin')

@section('admin-content')

@include('admin.exchange_rates.partials.form', [
    'exchangeRate' => $exchangeRate
])

@endsection
