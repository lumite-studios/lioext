<template>
    <component
        :is="`h${level}`"
        :class="classes"
    >
        <slot>{{ content }}</slot>
    </component>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = withDefaults(defineProps<{
    content?: null|string
    level?: '1'|'2'|'3'|'4'|'5'|'6'
    sub?: boolean
}>(), {
    content: null,
    level: '3'
})

const classes = computed((): (string|object)[] => {
    return [
        { 'font-heading font-medium tracking-wide': !props.sub },
        { 'text-base': props.level === '6' && !props.sub },
        { 'text-lg': props.level === '5' && !props.sub },
        { 'text-xl': props.level === '4' && !props.sub },
        { 'text-2xl': props.level === '3' && !props.sub },
        { 'text-3xl': props.level === '2' && !props.sub },
        { 'text-4xl': props.level === '1' && !props.sub },

        { 'opacity-75': props.sub },
        { 'text-xs': props.level === '6' && props.sub },
        { 'text-sm': props.level === '5' && props.sub },
        { 'text-base': props.level === '4' && props.sub },
        { 'text-lg': props.level === '3' && props.sub },
        { 'text-xl': props.level === '2' && props.sub },
        { 'text-2xl': props.level === '1' && props.sub },
    ]
})
</script>
