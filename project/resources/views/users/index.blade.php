@extends('layouts.app')

@section('breadcrumb')
    <breadcrumb header="Usuários">
        <breadcrumb-item href="{{ route('home') }}">
            @lang('headings._home')
        </breadcrumb-item>

        <breadcrumb-item active>
            @lang('headings.users.index')
        </breadcrumb-item>
    </breadcrumb>
@endsection

@section('content')
    <data-list data-source="{{ route('pagination.users') }}">
        <template #options>
            <div class="flex mb-5">
                <div class="w-10/12">
                    <filter-text url-key="query"
                                 class="form-input w-full"
                                 aria-placeholder="Buscar...">
                    </filter-text>
                </div>

                <div class="w-2/12">
                    <a :href="'{{ route('users.create') }}'">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Novo usuário
                        </button>
                    </a>
                </div>
            </div>
        </template>

        <template #header="{orderBy}">
            <tr class="text-left">
                @include('users.partials._head')
            </tr>
        </template>

        <template #body="{fetchData, items}">
            <tr v-for="(item, index) in items" :key="index">
                @include('users.partials._body')
            </tr>
        </template>
    </data-list>
@endsection