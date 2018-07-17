<template>
<div>
    <div class="row mt-1 mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" v-model="query" placeholder="Busca">
        </div>
        <div class="col-md-3">
            <div class="btn-group" role="group" aria-label="Marcar/Desmarcar">
                <button @click.prevent="selectAll()" class="btn btn-outline-secondary">
              Marcar todos
          </button>
                <button @click.prevent="unselectAll()" class="btn btn-outline-secondary">
              Desmarcar todos
          </button>
            </div>
        </div>
    </div>
    <div class="scroll-item position-relative border">
        <div class="form-control" v-for="item in data_options">
            <input type="checkbox" :id="getId(item)" v-model="data_selected" :value="item[valueKey]" :name="getName()">
            <label :for="getId(item)">
              {{ item[label] }}
          </label>
        </div>
    </div>
</div>
</template>

<script>
import _ from 'lodash';

export default {
    name: "select-box",

    props: {
        options: {
            required: true,
        },

        valueKey: {
            type: String,
            default () {
                return 'id';
            },
        },

        label: {
            type: String,
            default () {
                return 'text';
            },
        },

        selected: {
            type: Array,
            default () {
                return [];
            }
        },

        name: {
            type: String,
            required: true,
        },
    },

    watch: {
        query: _.debounce(function(newQuery) {
            this.search(newQuery);
        }, 500),

        data_selected: function(data_selected) {
            const payload = {
                name: this.name.replace('[]', ''),
                data: data_selected,
            };

            this.$emit('selectedElements', payload);
            this.$root.$emit('selectedElements', payload);
        },

        options: function(options) {
            this.setAllOptions();
        },
    },

    mounted() {
        this.setSelected();
        this.setAllOptions();
    },

    data() {
        return {
            query: undefined,
            all_options: [],
            data_options: [],
            data_selected: [],
        };
    },

    methods: {
        getId(item) {
            let id = this.name.replace(/[^\w_]/g, '');
            id += '-' + item[this.valueKey];
            return id;
        },

        getName() {
            if (this.name.endsWith('[]')) {
                return this.name;
            }
            return this.name + '[]';
        },

        selectAll() {
            let selections = [];

            for (var el in this.data_options) {
                let value = this.data_options[el][this.valueKey]
                selections.push(value);
            }

            this.data_selected = selections;
        },

        unselectAll() {
            this.data_selected = [];
        },

        setAllOptions() {
            this.all_options = Object.values(this.options).sort((a, b) => {
                let first = a[this.label].toLowerCase();
                let second = b[this.label].toLowerCase();

                if (first > second) {
                    return 1;
                }

                if (first < second) {
                    return -1;
                }

                return 0;
            });
            this.resetDataOptions();
        },

        setSelected() {
            if (typeof this.selected !== 'undefined' && this.selected !== null) {
                this.data_selected = Object.values(this.selected);
            }
        },

        resetDataOptions() {
            this.data_options = this.all_options;
        },

        search(query) {
            if (!query) {
                this.resetDataOptions();
                return;
            }

            query = query.toLowerCase();
            this.data_options = this.all_options.filter((el) => {
                return el[this.label].toLowerCase().search(query) != -1;
            });
        },
    },
}
</script>

<style lang="scss" scoped>
.scroll-item {
    overflow-y: scroll;
    max-height: 166px;
    min-height: 76px;

    .form-control {
        display: block;
        padding: 0.25rem 0.5rem;
    }
}
</style>
