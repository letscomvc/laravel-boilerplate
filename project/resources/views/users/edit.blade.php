@extends('layouts.app')

@section('breadcrumb')
<breadcrumb header="Editar usuário">
    <breadcrumb-item href="{{ route('home') }}">
        @lang('headings._home')
    </breadcrumb-item>

    <breadcrumb-item active>
        @lang('headings.users.edit')
    </breadcrumb-item>
</breadcrumb>
@endsection

@section('content')
<div class="card">
    <div class="card-header">@lang('headings.users.edit')</div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">
            @method('PUT')
            @include('users.partials._form')
            <button class="btn btn-primary" type="submit">@lang('buttons.common.edit')</button>
        </form>
    </div>
</div>
@endsection
