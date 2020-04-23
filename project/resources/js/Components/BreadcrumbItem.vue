<template>
    <li v-if="active" class="flex items-center active text-gray-600">
        <slot>Link</slot>
    </li>
    <li v-else class="flex items-center text-gray-700">
        <a class="cursor-pointer" :href="href">
            <slot>Link</slot>
        </a>
        <span class="mx-1">/</span>
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
