<template>
    <div>
        <slot name="options">
        </slot>

        <table class="col-12">
            <thead>
                <slot name="header" :orderBy="orderBy"></slot>
            </thead>
            <tbody>
                <slot name="body" :fetchData="fetchData" :items="items"></slot>
            </tbody>
        </table>

        <pagination
          class="col-10"
          :total-pages="totalPages"
          :current-page="currentPage"
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
          this.$emit('stop-loading');
        });
      },

      fetchPrevPage() {
        this.currentPage = this.currentPage - 1;
        this.fetchData();
      },

      fetchNextPage() {
        this.currentPage = this.currentPage + 1;
        this.fetchData();
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
