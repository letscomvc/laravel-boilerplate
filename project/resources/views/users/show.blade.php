@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="Visualizar usuário">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings.users.create')
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
