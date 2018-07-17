<template>
    <input type="checkbox" v-model="checked"/>
</template>

<script>
import _ from 'lodash';
import filter from './FilterMixin'

export default {
    name: 'filter-checkbox',

    mixins: [filter],

    watch: {
      checked: _.debounce(function (checked) {
          this.submit(checked);
      }, 200),
    },

    data: () => {
        return {
            checked: false,
        }
    },
}
</script>
