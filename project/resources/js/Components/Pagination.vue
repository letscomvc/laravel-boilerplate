<template>
  <div style="text-align:center;">
    <div class="custom-pagination" v-if="shouldShowPagination">
      <div class="row center">
        <div class="col-xs-12 col-sm-3 col-md-3">
          <label
            class="col-xs-12 col-md-6 btn btn-light"
            :disabled="!enabledPrevPageButton"
            @click="fetchPrevPage" >
            Anterior
          </label>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-6">
          <label class="btn btn-light"
                 v-for="button in paginationButtons"
                 :ref="'paginationButton' + button.page"
                 :class="{'active': button.active, 'disabled': button.disabled}"
                 @click="changePage(button.page)" >
            {{button.text}}
          </label>
        </div>

        <div class="col-xs-12 col-sm-3 col-md-3">
          <label
            class="col-xs-12 col-md-6 btn btn-light"
            :disabled="!enabledNextPageButton"
            @click="fetchNextPage" >
            Próxima
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "pagination",

  props: {
    totalPages: {
      required: true,
    },
    currentPage: {
      required: true,
    },
  },

  data() {
    return {
      paginationButtons: [],
      currentPageMutable: 1,
    }
  },

  watch: {
    totalPages() {
      this.definePaginationButtons();
    },

    currentPageMutable() {
      this.definePaginationButtons();
    },
  },

  computed: {
    enabledNextPageButton() {
      return this.currentPage < this.totalPages;
    },

    enabledPrevPageButton() {
      return this.currentPage > 1;
    },

    shouldShowPagination() {
      return this.totalPages > 1;
    },
  },

  methods: {
    fetchPrevPage() {
      if (this.enabledPrevPageButton) {
        this.currentPageMutable--;
        this.$emit('changePage', this.currentPageMutable);
      }
    },

    fetchNextPage() {
      if (this.enabledNextPageButton) {
        this.currentPageMutable++;
        this.$emit('changePage', this.currentPageMutable);
      }
    },

    changePage(page) {
      this.currentPageMutable = page;
      this.$emit('changePage', page);
    },

    definePaginationButtons() {
      const totalPages = this.totalPages;
      let startPage = this.currentPage - 4;
      let endPage = this.currentPage + 4;
      let buttons = [];

      if (startPage <= 0) {
        endPage -= (startPage - 1);
        startPage = 1;
      }

      if (endPage > totalPages)
        endPage = totalPages;

      if (startPage > 1) {
        buttons.push({
          disabled: false,
          page: 1,
          text: '1'
        });
        buttons.push({
          disabled: true,
          page: 0,
          text: '...'
        });
      }

      for (let i = startPage; i <= endPage; i++) {
        const active = (i == this.currentPageMutable);
        buttons.push({
          disabled: false,
          page: i,
          text: i,
          active: active
        });
      }

      if (endPage < totalPages) {
        buttons.push({
          disabled: true,
          page: 0,
          text: '...'
        });
        buttons.push({
          disabled: false,
          page: totalPages,
          text: totalPages
        });
      }

      this.paginationButtons = buttons;
    },
  },
}
</script>
