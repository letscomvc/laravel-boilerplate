<template>
    <div>
        <slot name="options">
        </slot>

        <table class="w-full">
            <thead>
                <slot name="header" :orderBy="orderBy"></slot>
            </thead>
            <tbody>
                <slot name="body" :fetchData="fetchData" :items="items"></slot>
            </tbody>
        </table>

        <pagination
          class="w-10/12"
          :pagination-buttons="paginationButtons"
          @fetchPrevPage="fetchPrevPage"
          @fetchNextPage="fetchNextPage"
          @changePage="page => changePage(page)">
        </pagination>
    </div>
</template>

<script>
  import SortIcon from '../support/SortIcon.js';
  import Pagination from "./Pagination";

  export default {
      components: {Pagination},
      props: {
      dataSource: {
        type: String,
      },
    },

    computed: {
      queryFilters() {
        let queryFilters = '';
        for (var filterName in this.filters) {
          if (this.filters.hasOwnProperty(filterName)) {
            queryFilters += '&' + filterName + '=' + this.filters[filterName];
          }
        }
        return queryFilters;
      },

      fetchUrl() {
        let queryParams = '';
        queryParams += '?field=' + this.field;
        queryParams += '&order=' + this.sortIcon.order;

        if (this.currentPage != 1) {
          queryParams += '&page=' + this.currentPage;
        }

        queryParams += this.queryFilters;

        const url = this.dataSource + queryParams;
        return encodeURI(url);
      },

      noResults() {
        return this.items.length == 0;
      },

      enabledNextPageButton() {
        return this.currentPage < this.totalPages;
      },

      enabledPrevPageButton() {
        return this.currentPage > 1;
      },

      shouldShowPagination() {
        return this.totalPages > 1;
      },

      isNotLoading() {
        return !this.loading;
      },
    },

    data: function () {
      return {
        items: [],

        loading: true,

        field: '',

        sortIcon: new SortIcon,
        totalPages: 1,
        currentPage: 1,
        itemsPerPage: 15,
        paginationButtons: [],
        departmentId: null,

        count: {
          actives: 0,
          inactives: 0,
        },

        filters: {},
      }
    },

    mounted() {
      this.sortIcon.setArrow();
      this.listenFilters();
      this.listenLoadingEvents();
      this.fetchData();
    },

    methods: {
      orderBy(field, event) {
        this.field = field;
        this.sortIcon.change(event);
        this.fetchData();
      },

      setPagination(fetched_data) {
        this.currentPage = fetched_data.current_page;
        this.totalPages = fetched_data.last_page;
        this.itemsPerPage = fetched_data.per_page;
      },

      fetchData() {
        this.$emit('start-loading');
        axios.get(this.fetchUrl).then((response) => {
          this.items = response.data.data;
          this.setPagination(response.data.meta);
          this.definePaginationButtons();
          this.$emit('stop-loading');
        });
      },

      fetchPrevPage() {
        if (this.enabledPrevPageButton) {
          this.currentPage = this.currentPage - 1;
          this.fetchData();
        }
      },

      fetchNextPage() {
        if (this.enabledNextPageButton) {
          this.currentPage = this.currentPage + 1;
          this.fetchData();
        }
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
          const active = (i == this.currentPage);
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

      changePage(page) {
        this.currentPage = page;
        this.fetchData();
      },

      listenFilters() {
        this.$on('setFilter', (payload) => {
          this.setFilter(payload.urlKey, payload.value);
          this.fetchData();
        });
      },

      setFilter(name, value) {
        if (value) {
          this.$set(this.filters, name, value)
        } else {
          delete this.filters[name];
          this.filters = Object.assign({}, this.filters);
        }
      },

      listenLoadingEvents() {
        this.$on('start-loading', () => {
          this.loading = true;
        });

        this.$on('stop-loading', () => {
          this.loading = false;
        });
      },
    },
  }
</script>
