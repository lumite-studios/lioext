<template>
    <Head :title="'Image'" />
    <XPageLayout>
        <template #sidebar>
            <MessagePartial />
            <FormPartial v-model:form="form" />
            <div class="flex items-center justify-end">
                <PrimeButton
                    label="Generate"
                    :loading="form.processing"
                    @click="generate"
                />
            </div>
        </template>
        <XActionLoading v-if="form.processing" />
        <XEmptyResults v-else-if="base64 === null">
            {{ 'No image generated.' }}
        </XEmptyResults>
        <div
            v-else
            class="h-full flex items-center justify-center"
        >
            <img :src="base64">
        </div>
    </XPageLayout>
</template>

<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3'
import PrimeButton from 'primevue/button'
import { XActionLoading, XEmptyResults, XPageLayout } from '@/views/components'
import { FormPartial, MessagePartial } from './_components'
import type { Form } from './image.typings'

withDefaults(defineProps<{
    base64?: null|string,
}>(), {
    base64: null,
})

const form = useForm<Form>({
    url: 'https://www.lioden.com/lion.php?mid=96301',
    background: false,
    decorations: false,
    cubs: false,
    forceAdultMale: false,
    forceAdultFemale: false,
    opacity: false,
})

/**
 * Generate a lion image.
 * @returns {void}
 */
const generate = (): void => {
    form.post('/image', {
        only: ['base64'],
    })
}
</script>
