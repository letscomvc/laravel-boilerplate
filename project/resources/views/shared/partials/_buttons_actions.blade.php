<div v-if="item.links">
    <a v-if="item.links.show" :href="item.links.show">
        <button type="button" class="btn btn-info">
            Ver
        </button>
    </a>

    <a v-if="item.links.edit" :href="item.links.edit">
        <button type="button" class="btn btn-primary">
            Editar
        </button>
    </a>

    <a v-if="item.links.destroy" @click.prevent="confirmDelete(item.links.destroy)">
        <button type="button" class="btn btn-danger">
            Apagar
        </button>
    </a>

    @yield('button-actions')
</div>
