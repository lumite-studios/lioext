<template>
    <component
        :is="!href ? 'span' : 'a'"
        :class="classes"
        :href="href"
        rel="noopener noreferrer"
        target="_blank"
    >
        <slot>{{ content }}</slot>
    </component>
</template>

<script setup lang="ts">
import { computed } from 'vue'

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
