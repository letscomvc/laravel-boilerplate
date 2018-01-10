<div style="text-align:center;">
  <div class="custom-pagination" v-if="shouldShowPagination">
    <div class="row">
      <div class="col-md-3">
        <button class="btn btn-default pull-right" @click="fetchPrevPage" :disabled="!enabledPrevPageButton">
          Anterior
        </button>
      </div>

      <div class="col-md-3 ">
          {{-- page buttons --}}
      </div>

      <div class="col-md-3 col-md-offset-6">
        <button class="btn btn-default pull-left" @click="fetchNextPage" :disabled="!enabledNextPageButton">
          Próxima
        </button>
      </div>
    </div>
  </div>
</div>
