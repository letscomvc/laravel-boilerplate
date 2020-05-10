<template>
    <input v-model="value" :placeholder="placeholder">
</template>

<script>
import _ from 'lodash';
import filter from './FilterMixin'

export default {
    name: 'filter-text',

    mixins: [filter],

    props: {
        placeholder: {
            required: false,
            default: 'Buscar...',
        }
    },

    watch: {
      value: _.debounce(function (val) {
        this.submit(val);
      }, 500),
    },

    data: () => {
        return {
            value: undefined,
        }
    },
}
</script>
