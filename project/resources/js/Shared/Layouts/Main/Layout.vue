<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <slot/>
        </div>
    </div>
</template>

<script>
  import Navbar from "./Navbar";

  export default {
    name: 'layout',

    components: {
      Navbar,
    },

    methods: {
      url() {
        return location.pathname.substr(1)
      },
    },
  }

</script>

<style scoped>

</style>