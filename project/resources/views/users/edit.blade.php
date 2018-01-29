@extends('layouts.app')

@section('content')
    <div class="container pt-3">
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
    </div>
@endsection
