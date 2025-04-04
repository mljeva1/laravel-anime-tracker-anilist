@extends('layouts.app')

@section('content')
    @foreach ($roles as $role)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $role->role_name }}
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        {{ $role->id }}
    </li>
    @endforeach
@endsection