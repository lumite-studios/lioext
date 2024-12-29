<template>
    <Head :title="'RLC'" />
    <XPageLayout>
        <template #sidebar>
            <MessagePartial />
            <div v-if="form.hasErrors">
                {{ form.errors }}
            </div>
            <FormPartial
                v-model:form="form"
                :years="years"
            />
            <div class="flex items-center justify-end">
                <PrimeButton
                    label="Search"
                    :loading="form.processing"
                    @click="search"
                />
            </div>
        </template>
        <XActionLoading v-if="form.processing" />
        <XEmptyResults v-else-if="matches.length === 0">
            {{ 'There are no matches to show.' }}
        </XEmptyResults>
        <div
            v-else
            class="grid grid-cols-3 gap-3"
        >
            <MatchPartial
                v-for="match in matches"
                :key="match.date"
                :match="match"
            />
        </div>
    </XPageLayout>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import PrimeButton from 'primevue/button'
import { XActionLoading, XEmptyResults, XPageLayout } from '@/views/components'
import { FormPartial, MatchPartial, MessagePartial } from './_components'
import { parts, type Form, type Match } from './rlc.typings'

const props = defineProps<{
    matches: Match[],
    years: string[]
}>()

const compares = ref<string[]>(parts)

const form = useForm<Form>({
    compares: compares.value,
    percentage: parts.length,
    url: 'https://www.lioden.com/lion.php?mid=96301',
    years: props.years,
})

const search = () => {
    form.post('/rlc')
}
// watch(compares, () => form.compares = compares.value)
</script>
