<div v-if="item.links">
    <a v-if="item.links.show"
       :href="item.links.show"
       class=" bg-blue-500 hover:bg-blue-600 text-white font-bold px-3 py-2 rounded inline-block sm:w-10 md:w-auto">
        <span class="md:inline mr-0 md:mr-1"><i class="fa fa-search"></i></span>
        <span class="md:inline hidden">@lang('links._show')</span>
    </a>

    <a v-if="item.links.edit"
       :href="item.links.edit"
       class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-3 py-2 rounded inline-block sm:w-10 md:w-auto">
        <span class="md:inline mr-0 md:mr-1"><i class="fa fa-edit"></i></span>
        <span class="md:inline hidden">@lang('links._edit')</span>
    </a>

    <delete-button :link="item.links.destroy" :fetch-data="fetchData">
        <confirmable class="inline"
                     slot-scope="{handleDelete}"
                     title="{{$confirmDeleteTitle ?? 'Excluir registro'}}"
                     message="{{$confirmDeleteMessage ?? 'Tem certeza que deseja apagar este registro?'}}">
            <span v-if="item.links.destroy"
                  slot-scope="{confirm}"
                  @click="confirm($event, handleDelete)"
                  class="cursor-pointer bg-red-500 hover:bg-red-600 text-white font-bold px-3 py-2 rounded inline-block sm:w-10 md:w-auto">
                    <span class="md:inline mr-0 md:mr-1"><i class="fa fa-close"></i></span>
                    <span class="md:inline hidden">@lang('links._destroy')</span>
            </span>
        </confirmable>
    </delete-button>

    @yield('button-actions')
</div>
