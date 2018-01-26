<div style="text-align:center;">
    <div class="custom-pagination" v-if="shouldShowPagination">
        <div class="row center">
            <div class="col-xs-12 col-sm-3 col-md-3">
                <button class="col-xs-12 col-md-6 btn btn-default pull-right" @click="fetchPrevPage" :disabled="!enabledPrevPageButton">
                    Anterior
                </button>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-6">
                <label class="btn btn-default"
                    v-for="button in paginationButtons"
                    :ref="'paginationButton' + button.page"
                    :class="{'active': button.active}"
                    :disabled="button.disabled"
                    @click="changePage(button.page)" >
                        @{{button.text}}
                </label>
            </div>

            <div class="col-xs-12 col-sm-3 col-md-3">
                <button class="col-xs-12 col-md-6 btn btn-default pull-left" @click="fetchNextPage" :disabled="!enabledNextPageButton">
                    Próxima
                </button>
            </div>
        </div>
    </div>
</div>
