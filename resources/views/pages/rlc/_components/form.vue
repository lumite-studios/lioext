<template>
    <div class="flex flex-col space-y-2">
        <XFormInput
            label="Lion URL"
            required
        >
            <PrimeInputText
                v-model="form.url"
                type="text"
            />
        </XFormInput>
        <XFormInput
            label="RL Years"
            description="Which years to select the RLs from."
            required
        >
            <PrimeMultiSelect
                v-model="form.years"
                display="chip"
                :options="years"
            />
        </XFormInput>
        <XFormInput
            label="Compare"
            description="What parts of a lion's appearance should be compared."
        >
            <PrimeMultiSelect
                v-model="form.compares"
                display="chip"
                :options="parts"
            />
        </XFormInput>
        <XFormInput
            label="Minimum Percentage"
            :description="`Only show lions that have at least a(n) ${percentage}% match.`"
        >
            <PrimeSlider
                v-model="form.percentage"
                class="mt-3"
                :max="parts.length"
                :min="1"
                :step="1"
            />
        </XFormInput>
    </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
import type { InertiaForm } from '@inertiajs/vue3'
import PrimeInputText from 'primevue/inputtext'
import PrimeMultiSelect from 'primevue/multiselect'
import PrimeSlider from 'primevue/slider'
import { XFormInput } from '@/views/components'
import { parts, type Form, type Props } from '../rlc.typings'

defineProps<Props>()

const form = defineModel('form', { required: true, type: Object as () => InertiaForm<Form> })

const compares = ref<string[]>(parts)
const percentage = computed((): number => {
    return (form.value.percentage / compares.value.length) * 100
})
</script>
