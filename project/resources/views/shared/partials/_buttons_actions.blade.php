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

    <delete-button class="d-inline" :link="item.links.destroy" @deleted="fetchData()">
        <confirmable
            class="d-inline"
            slot-scope="{handleDelete}"
            title="{{$confirmDeleteTitle ?? 'Excluir registro'}}"
            message="{{$confirmDeleteMessage ?? 'Tem certeza que deseja apagar este registro?'}}">
            <a v-if="item.links.destroy"
               slot-scope="{confirm}"
               @click="confirm($event, handleDelete)">
                <button type="button" class="btn btn-danger">
                    @lang('links._destroy')
                </button>
            </a>
        </confirmable>
    </delete-button>
    @yield('button-actions')
</div>
