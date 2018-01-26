@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Editar usuário</div>

            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">
                    @method('PUT')
                    @include('users.partials._form')
                    <button class="btn btn-primary" type="submit">@lang('buttons.common.edit')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
