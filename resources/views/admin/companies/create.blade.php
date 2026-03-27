@extends('admin.layouts.admin')

@section('admin-content')
    @include('admin.companies.partials.form', [
        'title' => 'Nueva compañía',
        'subtitle' => 'Crea una nueva compañía operadora.',
        'action' => route('admin.companies.store'),
        'method' => 'POST',
        'buttonText' => 'Crear compañía',
    ])
@endsection