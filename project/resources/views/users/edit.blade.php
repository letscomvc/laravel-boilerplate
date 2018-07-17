@extends('layouts.app')

@section('breadcrumb')
<breadcrumb header="Editar usuário">
    <breadcrumb-item href="{{ route('home') }}">
        Home
    </breadcrumb-item>

    <breadcrumb-item active>
        Usuários
    </breadcrumb-item>
</breadcrumb>
@endsection

@section('content')
<div class="card">
    <div class="card-header">Cadastrar usuário</div>
    <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">
            @method('PUT')
            @include('users.partials._form')
            <button class="btn btn-primary" type="submit">@lang('buttons.common.edit')</button>
        </form>
    </div>
</div>
@endsection
