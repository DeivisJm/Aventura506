@extends('admin.layouts.admin')

@section('admin-content')

@include('admin.users.partials.form', [
'user' => $user,
'roles' => $roles
])

@endsection