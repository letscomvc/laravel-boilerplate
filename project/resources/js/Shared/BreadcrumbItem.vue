<template>
    <li v-if="active" class="breadcrumb-item active">
        <slot>Breadcrumb Item</slot>
    </li>
    <li v-else class="breadcrumb-item">
        <a :href="href">
            <slot>Breadcrumb Item</slot>
        </a>
    </li>
</template>

<script>
export default {
    name: "breadcrumb-item",

    props: {
        href: {
            required: false,
            type: String,
            default: () => {
                return '#';
            },
        },
        active: {
            required: false,
            type: Boolean,
            default: () => {
                return false;
            }
        },
    },
}
</script>
