<template>
    <div>
        Default layout
        <slot />
    </div>
</template>

<script>
  export default {
    name: "main",

    methods: {
      url() {
        return location.pathname.substr(1)
      },
    },
  }

</script>

<style scoped>

</style>