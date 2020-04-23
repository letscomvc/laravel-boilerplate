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
    <div class="flex flex-wrap justify-center">
        <div class="w-full">
            <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">
                <div class="w-full p-6">
                    <div class="flex flex-wrap mb-6">
                        <label for="userName" class="block text-gray-700 text-sm font-bold mb-2">
                            Nome
                        </label>
                        <input type="text" name="name" class="form-input w-full" id="userName"
                               placeholder="Nome do usuário" value="{{ $user->name }}" disabled>
                    </div>

                    <div class="flex flex-wrap mb-6">
                        <label for="userEmail" class="block text-gray-700 text-sm font-bold mb-2">
                            Email
                        </label>
                        <input type="email" name="email" class="form-input w-full" id="userEmail"
                               placeholder="Email do usuário" value="{{ $user->email }}" disabled>
                    </div>

                    <a
                        href="{{ route('users.index') }}"
                        class="bg-blue-400 hover:bg-blue-500 text-white font-bold px-3 py-2 rounded mx-auto"
                        type="submit">
                        @lang('links._back')
                    </a>
                    <a
                        href="{{ route('users.edit', $user->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-3 py-2 rounded mx-auto"
                        type="submit">
                        @lang('links._edit')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
