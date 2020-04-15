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

   <confirmable class="d-inline"
        title="{{$confirmDeleteTitle ?? 'Excluir registro'}}"
        message="{{$confirmDeleteMessage ?? 'Tem certeza que deseja apagar este registro?'}}">
        <a v-if="item.links.destroy"
           slot-scope="{confirm}"
           @click="confirm($event, () => handleDelete(item.links.destroy))">
            <button type="button" class="btn btn-danger">
                @lang('links._destroy')
            </button>
        </a>
    </confirmable>
    @yield('button-actions')
</div>
