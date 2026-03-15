@extends('admin.layouts.admin')

@section('admin-content')

@include('admin.users.partials.form', [
'user' => new \App\Models\User(),
'roles' => $roles
])

@endsection