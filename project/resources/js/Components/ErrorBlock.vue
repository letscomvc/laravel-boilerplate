<template>
  <div v-if="getFieldErrors().length" class="text-red-500 text-sm">
    {{ getFieldErrors()[0] }}
  </div>
</template>

<script>
import {get as data_get} from 'lodash';

export default {
  name: "ErrorBlock",

  props: {
    field: String,
  },

  computed: {
    pageErrors() {
      return this.$page.props.errors;
    }
  },

  methods: {
    getFieldErrors() {
      return data_get(this.pageErrors, this.field, []);
    }
  },
}
</script>

<style scoped>

</style>
