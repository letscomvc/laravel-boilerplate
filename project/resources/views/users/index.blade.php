@extends('layouts.app')

@section('content')
        <data-list data-source="{{ route('pagination.users') }}"
                   delete-message="Tem certeza que deseja apagar este registro ?"
                   url-create="{{ route('users.create') }}"
                   label-create="Novo usuário"
                   />
@endsection

@section('custom-template')
    <template id="data-list" slot-scope="modelScope">
        <div>
            <div class="row">
                <div class="col-md-6">
                    <a v-if="urlCreate" :href="urlCreate">
                        <button class="btn btn-primary">@{{labelCreate}}</button>
                    </a>
                </div>
                <div class="col-md-6">
                    <input type="text" v-model="query" class="form-control">
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        @include('users.partials._head')
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        @include('users.partials._body')
                        <td>@include('shared.partials._buttons_actions')</td>
                    </tr>
                </tbody>
            </table>
            @include('shared.partials._pagination')
        </div>
    </template>
@endsection
