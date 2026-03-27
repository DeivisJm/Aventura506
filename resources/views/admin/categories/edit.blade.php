@extends('admin.layouts.admin')

@section('admin-content')
    @include('admin.categories.partials.form', [
        'title' => 'Editar categoría',
        'subtitle' => 'Actualiza la información de la categoría seleccionada.',
        'action' => route('admin.categories.update', $category),
        'method' => 'PUT',
        'buttonText' => 'Actualizar categoría',
    ])
@endsection