<div v-if="item.links">
    <a v-if="item.links.show" :href="item.links.show">
        <button type="button" class="btn btn-light">
            @lang('links._show')
        </button>
    </a>

    <a v-if="item.links.edit" :href="item.links.edit">
        <button type="button" class="btn btn-primary">
            @lang('links._edit')
        </button>
    </a>

    <a v-if="item.links.destroy" @click.prevent="confirmDelete(item.links.destroy)">
        <button type="button" class="btn btn-danger">
            @lang('links._destroy')
        </button>
    </a>

    @yield('button-actions')
</div>
