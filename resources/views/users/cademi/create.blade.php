@extends('layouts.app')

@section('title', "Novo Usuário Cademi {$user->name}")

@section('content')
<h1 class="text-2xl font-semibold leading-tigh py-2">
    Novo Comentário Para o Usuário {{ $user->name }}
</h1>

@include('includes.validations-form')

<form action="{{ route('cademi.create', $user->id) }}" method="post">
    @include('users.cademi._partials.form')
</form>

@endsection
