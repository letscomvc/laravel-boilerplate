<template>
    <nav class="text-black font-bold my-3" aria-label="Breadcrumb">
        <div class="align-self-center">
            <h3 v-if="header" class="text- m-b-0 m-t-0">{{ header }}</h3>
            <ol class="list-none p-0 inline-flex">
                <slot></slot>
            </ol>
        </div>
    </nav>
</template>

<script>
  export default {
    name: "breadcrumb",

    props: {
      header: {
        type: String,
        required: false,
      }
    },
  }
</script>
