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
    paginationButtons: {
      required: true,
    },
  },

  computed: {
    shouldShowPagination() {
      return this.$parent.shouldShowPagination;
    },

    enabledPrevPageButton() {
      return this.$parent.enabledPrevPageButton;
    },

    enabledNextPageButton() {
      return this.$parent.enabledNextPageButton;
    },
  },

  methods: {
    fetchPrevPage() {
      this.$parent.fetchPrevPage();
    },

    fetchNextPage() {
      this.$parent.fetchNextPage();
    },

    changePage(page) {
      this.$parent.changePage(page);
    }
  },
}
</script>
