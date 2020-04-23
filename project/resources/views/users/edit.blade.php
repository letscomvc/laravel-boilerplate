@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="Editar usuário">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings._home')
        </breadcrumb-item>

        <breadcrumb-item href="{{ route('users.index') }}">
            @lang('headings.users.index')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.users.edit')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <div class="flex flex-wrap justify-center">
        <div class="w-full">
            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
                <form class="w-full p-6" method="POST" action="{{ route('users.update', $user->id) }}">
                    @method('PUT')
                    @include('users.partials._form')
                    <button class="bg-blue-400 hover:bg-blue-500 text-white font-bold px-3 py-2 rounded mx-auto"
                            type="submit">@lang('links._update')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
