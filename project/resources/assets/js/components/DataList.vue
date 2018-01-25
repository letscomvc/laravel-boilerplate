<script>
export default {
    template: '#data-list',

    props: {
        dataSource: {
            type: String,
        },

        urlCreate: {
            type: String,
            default() {
                return null;
            },
        },

        labelCreate: {
            type: String,
            default() {
                return 'Cadastrar novo';
            },
        },

        deleteMessage: {
            type: String,
            default() {
                return 'Tem certeza que deseja apagar este registro ?';
            },
        },
    },

    watch: {
        query: _.debounce(function(text) {
            this.fetchData();
        }, 300),
    },

    computed: {
        fetch_url() {
            let query_params = '';
            query_params = '?query=' + this.query;
            query_params += '&field=' + this.field;
            query_params += '&order=' + this.order;

            if (this.currentPage != 1) {
                query_params += '&page=' + this.currentPage;
            }

            const url = this.dataSource + query_params;
            return url;
        },

        enabledNextPageButton() {
            return this.currentPage < this.totalPages;
        },

        enabledPrevPageButton() {
            return this.currentPage > 1;
        },

        shouldShowPagination() {
            return this.totalPages > 1;
        }
    },

    data: function() {
        return {
            items: [],

            query: '',
            field: '',
            order: 'asc',

            totalPages: 1,
            currentPage: 1,
            itemsPerPage: 15,
        }
    },

    mounted() {
        this.fetchData();
    },

    methods: {
        getArrow() {
            let arrow_classes = '';
            if (this.order == 'asc') {
                arrow_classes = 'fa fa-angle-up order-arrow'
            } else {
                arrow_classes = 'fa fa-angle-down order-arrow'
            }

            const arrow = document.createElement('i');
            arrow.className = arrow_classes;

            return arrow;
        },

        defineOrder() {
            this.order = (this.order == 'asc') ? 'desc' : 'asc';
            return this.order;
        },

        setOrderArrowIn(element) {
            let arrows = document.querySelectorAll('.order-arrow');
            arrows.forEach((node) => {
                node.parentNode.removeChild(node);
            });

            element.appendChild(this.getArrow());
        },

        orderBy(field, event) {
            this.field = field;
            this.defineOrder();
            this.setOrderArrowIn(event.target);
            this.fetchData();
        },

        setPagination(fetched_data) {
            this.currentPage = fetched_data.current_page;
            this.totalPages = fetched_data.last_page;
            this.itemsPerPage = fetched_data.per_page;
        },

        fetchData() {
            axios.get(this.fetch_url).then((response) => {
                this.items = response.data.data;
                this.setPagination(response.data.meta);
            })
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

        handleDelete(link) {
             axios.delete(link).then((response) => {
                const status = response.data;
                this.$snotify[status.type](status.message);
                this.fetchData();
             });
        },

        confirmDelete(link, message = undefined) {

            if (message == undefined){
                message = this.deleteMessage;
            }

            this.$snotify.confirm(message, 'Excluir registro', {
              timeout: 5000,
              showProgressBar: false,
              closeOnClick: true,
              pauseOnHover: false,
              buttons: [
                {text: 'Sim', action: () => this.handleDelete(link) , bold: false},
                {text: 'Não'},
              ]
            });
        },

        changePage(p) {
            console.log(p)
        },
    },
}
</script>
