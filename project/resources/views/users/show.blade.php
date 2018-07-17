@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="Visualizar usuário">
        <breadcrumb-item href="{{ route('home') }}">
            Home
        </breadcrumb-item>

        <breadcrumb-item active>
            Usuários
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    {{$user->name}} <br>
    {{$user->email}}
@endsection
