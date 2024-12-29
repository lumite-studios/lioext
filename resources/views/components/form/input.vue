<template>
    <div class="w-full">
        <label class="block font-medium">{{ label }} <XRequired v-if="required" /></label>
        <div
            v-if="description"
            class="text-sm opacity-60 italic mb-0.5"
        >
            {{ description }}
        </div>
        <slot />
    </div>
</template>

<script setup lang="ts">
import { XRequired } from '../utils'

defineProps<{
    description?: string
    label: string
    required?: boolean
}>()
</script>
