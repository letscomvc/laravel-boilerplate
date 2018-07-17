<template>
<div class="row page-titles">
    <div class="col-12 align-self-center">
        <h3 v-if="header" class="text-themecolor m-b-0 m-t-0">{{ header }}</h3>
        <ol class="breadcrumb">
            <slot></slot>
        </ol>
    </div>
</div>
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
