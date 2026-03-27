@extends('admin.layouts.admin')

@section('admin-content')
    @include('admin.companies.partials.form', [
        'title' => 'Editar compañía',
        'subtitle' => 'Actualiza la información de la compañía seleccionada.',
        'action' => route('admin.companies.update', $company),
        'method' => 'PUT',
        'buttonText' => 'Actualizar compañía',
    ])
@endsection