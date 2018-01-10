<script>
    export default {
        template: '#model-list',

        props: {
            dataSource: {
                type: String,
            },
        },

        watch: {
            query: _.debounce(function(text){
                this.fetchData();
            }, 300),

            // currentPage() {
            //     this.fetchData();
            // },
        },

        computed: {
            fetch_url() {
                let query_params = '';
                query_params  = '?query=' + this.query;
                query_params += '&field=' + this.field;
                query_params += '&order=' + this.order;

                if (this.currentPage != 1) {
                    query_params += '&page=' + this.currentPage;
                }

                let url = this.dataSource + query_params;

                return url;
            },

            enabledNextPageButton() {
                return this.currentPage < this.totalPages;
            },

            enabledPrevPageButton() {
                return this.currentPage > 1;
            },
        },

        data: function() {
            return {
                items: [],

                query: '',
                field: '',
                order: 'asc',

                totalPages: 1,
                currentPage: 1,
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

                let arrow = document.createElement('i');
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
            },

            fetchData() {
                axios.get(this.fetch_url).then((response) => {
                    this.items = response.data.data;
                    this.setPagination(response.data);
                })
            },

            fetchPrevPage() {
                if(this.enabledPrevPageButton) {
                    this.currentPage = this.currentPage - 1;
                    this.fetchData();
                }
            },

            fetchNextPage() {
                if(this.enabledNextPageButton) {
                    this.currentPage = this.currentPage + 1;
                    this.fetchData();
                }
            },
        },
    }
</script>
