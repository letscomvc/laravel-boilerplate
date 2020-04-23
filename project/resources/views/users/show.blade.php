@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="Visualizar usuário">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings._home')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('users.index') }}">
            @lang('headings.users.index')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.users.show')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    {{$user->name}} <br>
    {{$user->email}}
@endsection
