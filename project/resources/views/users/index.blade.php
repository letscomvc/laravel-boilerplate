@extends('layouts.app')

@section('content')
    <div class="container">
        <data-list data-source="{{ route('pagination.users') }}"
                   url-create="we"
                   delete-message="Tem certeza que deseja apagar este registro ?"
                   />
    </div>
@endsection

@section('custom-template')
    <template id="data-list" slot-scope="modelScope">
        <div>
            <div class="row">
                <div class="col-md-6">
                    <a v-if="urlCreate" :href="urlCreate">
                        <button class="btn btn-primary">NOVO</button>
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
                    </tr>
                </tbody>
            </table>
            @include('shared.partials._pagination')
        </div>
    </template>
@endsection
