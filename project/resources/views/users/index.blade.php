@extends('layouts.app')

@section('content')
    <div class="container">
        <model-list data-source="{{ route('users.pagination') }}" />
    </div>
@endsection

@section('custom-template')
    <template id="model-list" slot-scope="modelScope">
        <div>
            <input type="text" v-model="query">
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
            @include('shared.partials._pagination');
        </div>
    </template>
@endsection
