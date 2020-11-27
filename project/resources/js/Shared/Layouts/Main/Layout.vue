<template>
  <div>
    <navbar class="w-full"></navbar>
    <div class="w-full px-12">
      <slot/>
    </div>
  </div>
</template>

<script>
import Navbar from "./Navbar";

export default {
  name: 'Layout',

  components: {
    Navbar,
  },
}

</script>

<style scoped>

</style>
