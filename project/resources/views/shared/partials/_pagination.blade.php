<div style="text-align:center;">
    <div class="custom-pagination" v-if="shouldShowPagination">
        <div class="row center">
            <div class="col-xs-12 col-sm-3 col-md-3">
                <label
                    class="col-xs-12 col-md-6 btn btn-light"
                    :disabled="!enabledPrevPageButton"
                    @click="fetchPrevPage" >
                        @lang('pagination.previous')
                </label>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-6">
                <label class="btn btn-light"
                    v-for="button in paginationButtons"
                    :ref="'paginationButton' + button.page"
                    :class="{'active': button.active, 'disabled': button.disabled}"
                    @click="changePage(button.page)" >
                        @{{button.text}}
                </label>
            </div>

            <div class="col-xs-12 col-sm-3 col-md-3">
                <label
                    class="col-xs-12 col-md-6 btn btn-light"
                    :disabled="!enabledNextPageButton"
                    @click="fetchNextPage" >
                        @lang('pagination.next')
                </label>
            </div>
        </div>
    </div>
</div>
