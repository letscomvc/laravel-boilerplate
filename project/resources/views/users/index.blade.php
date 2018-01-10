@extends('layouts.app')

@section('content')
    <model-list
        data-source="{{ route('users.pagination') }}" />

    <template id="model-list" slot-scope="modelScope">
        <div>
            <input type="text" v-model="query">
            @include('shared.pagination');
            <table class="table">
                <thead>
                    <tr>
                        @include('users.partials._head')
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items"
                        :key="index">
                        @include('users.partials._body')
                    </tr>
                </tbody>
            </table>

        </div>
    </template>

@endsection
