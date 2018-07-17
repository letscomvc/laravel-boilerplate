@extends('layouts.app')

@section('breadcrumb')
<breadcrumb header="Criar usuário">
    <breadcrumb-item href="{{ route('home') }}">
        @lang('headings._home')
    </breadcrumb-item>

    <breadcrumb-item active>
        @lang('headings.users.create')
    </breadcrumb-item>
</breadcrumb>
@endsection

@section('content')
<div class="card">
    <div class="card-header">@lang('headings.users.create')</div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
            @include('users.partials._form')
            <button class="btn btn-primary" type="submit">@lang('links._create')</button>
        </form>
    </div>
</div>
@endsection
