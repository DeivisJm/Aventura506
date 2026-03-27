@extends('admin.layouts.admin')

@section('admin-content')
    @include('admin.categories.partials.form', [
        'title' => 'Nueva categoría',
        'subtitle' => 'Crea una nueva categoría para organizar los tours.',
        'action' => route('admin.categories.store'),
        'method' => 'POST',
        'buttonText' => 'Crear categoría',
    ])
@endsection