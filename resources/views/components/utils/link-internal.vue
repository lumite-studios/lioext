<template>
    <component
        :is="!href ? 'span' : Link"
        :class="classes"
        :href="href"
        :only="[]"
        preserve-scroll
    >
        <slot>{{ content }}</slot>
    </component>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

withDefaults(defineProps<{
    content?: null|string
    href?: null|string
}>(), {
    content: null,
    href: null,
})

const classes = computed(() => {
    return [
        'min-w-0',
        'inline-block',
        'cursor-pointer',
    ]
})
</script>
