<template>
    <component
        :is="`h${level}`"
        :class="[
            'leading-none',
        ]"
    >
        <div
            :class="[
                'font-heading',
                { 'text-base': level === '6' },
                { 'text-lg': level === '5' },
                { 'text-xl': level === '4' },
                { 'text-2xl': level === '3' },
                { 'text-3xl': level === '2' },
                { 'text-4xl': level === '1' },
            ]"
        >
            <slot>{{ content }}</slot>
        </div>
        <div
            v-if="!!$slots.sub"
            :class="[
                'opacity-75',
                { 'text-xs': level === '6' },
                { 'text-sm': level === '5' },
                { 'text-base': level === '4' },
                { 'text-lg': level === '3' },
                { 'text-xl': level === '2' },
                { 'text-2xl': level === '1' },
            ]"
        >
            <slot name="sub" />
        </div>
    </component>
</template>

<script setup lang="ts">
import { contentProp } from '@/composables/components/content'

defineProps({
    ...contentProp,

    level: {
        type: String,
        default: '3',
        validator: (v: string) => ['1', '2', '3', '4', '5', '6'].includes(v)
    },
})
</script>
