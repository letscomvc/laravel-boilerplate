<template>
  <div class="flex mt-8 text-center" v-if="shouldShowPagination">
    <div class="w-1/4 text-right">
      <label
        class="w-1/4 bg-gray-200 hover:bg-gray-400 px-4 py-2 rounded"
        :disabled="!enabledPrevPageButton"
        @click="fetchPrevPage">
        Anterior
      </label>
    </div>

    <div class="w-1/2">
      <label class="bg-gray-200 hover:bg-gray-400 text-black w-1/12 mx-1 px-3 py-2 rounded"
             v-for="button in paginationButtons"
             :ref="'paginationButton' + button.page"
             :class="{'bg-gray-400': button.active, 'disabled': button.disabled}"
             @click="changePage(button.page)" >
        {{button.text}}
      </label>
    </div>

    <div class="w-1/4 text-left">
      <label
        class="w-1/4 bg-gray-200 hover:bg-gray-400 px-4 py-2 rounded"
        :disabled="!enabledNextPageButton"
        @click="fetchNextPage" >
        Próxima
      </label>
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

    shouldShowPagination: {
      required: true,
    },

    enabledPrevPageButton: {
      required: true,
    },

    enabledNextPageButton: {
      required: true,
    },
  },

  data() {
    return {
      paginationButtons: [],
      currentPageData: 1,
    }
  },

  watch: {
    totalPages() {
      this.definePaginationButtons();
    },

    currentPageData() {
      this.definePaginationButtons();
    },
  },

  methods: {
    fetchPrevPage() {
      if (this.enabledPrevPageButton) {
        this.currentPageData--;
      }
      this.$emit('fetchPrevPage');
    },

    fetchNextPage() {
      if (this.enabledNextPageButton) {
        this.currentPageData++;
      }
      this.$emit('fetchNextPage');
    },

    changePage(page) {
      console.log(page);
      this.currentPageData = page;
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
        const active = (i == this.currentPageData);
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
