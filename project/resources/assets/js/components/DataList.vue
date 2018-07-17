<script>
import SortIcon from '../commons/SortIcon.js';

export default {
    template: '#data-list',

    props: {
        dataSource: {
            type: String,
        },

        urlCreate: {
            type: String,
            default () {
                return null;
            },
        },

        labelCreate: {
            type: String,
            default () {
                return 'Cadastrar novo';
            },
        },

        deleteMessage: {
            type: String,
            default () {
                return 'Tem certeza que deseja apagar este registro?';
            },
        },

        resendMessage: {
            type: String,
            default () {
                return 'Tem certeza que deseja reenviar este e-mail?'
            },
        },

        undeleteMessage: {
            type: String,
            default () {
                return 'Tem certeza que deseja restaurar este usuário?'
            },
        },

        deleteTitle: {
            type: String,
            default () {
                return 'Excluir registro';
            },
        },
    },

    watch: {
        query: _.debounce(function(text) {
            this.currentPage = 1;
            this.fetchData();
        }, 300),
    },

    computed: {
        queryFilters() {
            let query_filters = '';
            for (var filterName in this.filters) {
                if (this.filters.hasOwnProperty(filterName)) {
                    query_filters += '&' + filterName + '=' + this.filters[filterName];
                }
            }
            return query_filters;
        },

        fetch_url() {
            let query_params = '';
            query_params = '?query=' + this.query;
            query_params += '&field=' + this.field;
            query_params += '&order=' + this.sortIcon.order;

            if (this.currentPage != 1) {
                query_params += '&page=' + this.currentPage;
            }

            query_params += this.queryFilters;

            const url = this.dataSource + query_params;
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

    data: function() {
        return {
            items: [],

            loading: true,

            query: '',
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
            axios.get(this.fetch_url).then((response) => {
                this.items = response.data.data;
                this.setPagination(response.data.meta);
                this.definePaginationButtons();
                this.$emit('stop-loading');
                this.$nextTick().then(function() {
                    $('[data-toggle="popover"]').popover();
                });
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

        handleDelete(link) {
            axios.delete(link).then((response) => {
                const status = response.data;
                if (status.type) {
                    this.$snotify[status.type](status.message);
                    this.fetchData();
                } else {
                    this.$snotify.error('Action undefined');
                }
            });
        },

        activate(link) {
            axios.post(link).then((response) => {
                const status = response.data;
                if (status.type) {
                    this.$snotify[status.type](status.message);
                    $('.tooltip').remove();
                    this.fetchData();
                } else {
                    this.$snotify.error('Action undefined');
                }
            });
        },

        deactivate(link) {
            axios.post(link).then((response) => {
                const status = response.data;
                if (status.type) {
                    this.$snotify[status.type](status.message);
                    $('.tooltip').remove();
                    this.fetchData();
                } else {
                    this.$snotify.error('Action undefined');
                }
            });
        },

        confirmDelete(link, message = undefined) {
            if (message == undefined) {
                message = this.deleteMessage;
            }

            this.$snotify.confirm(message, this.deleteTitle, {
                timeout: 5000,
                showProgressBar: false,
                closeOnClick: true,
                pauseOnHover: false,
                buttons: [{
                        text: 'Sim',
                        action: () => this.handleDelete(link),
                        bold: false
                    },
                    {
                        text: 'Não'
                    },
                ]
            });
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

        setDepartmentId(id) {
            this.departmentId = id;
        }
    },
}
</script>
