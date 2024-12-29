<template>
    <Head :title="'DEV'" />
    <XPageLayout>
        <template #sidebar>
            <XFormInput label="LioImage">
                {{ 'no options' }}
            </XFormInput>
            <XFormInput label="LioRLC">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col space-y-2">
                        <PrimeButton
                            label="Generate 2025 - 2027"
                            :loading="Form2025To2027.processing"
                            @click="generate2025To2027"
                        />
                        <PrimeButton
                            label="Generate 2022 - 2024"
                            :loading="Form2022To2024.processing"
                            @click="generate2022To2024"
                        />
                    </div>
                </div>
            </XFormInput>
        </template>
        <div class="grid grid-cols-3 text-sm">
            <div>
                <div class="font-bold">
                    {{ 'RLC 2022 - 2023 Last Generated:' }}
                </div>
                <div>
                    {{ updates['rlc-2022-2024'] ?? 'never' }}
                </div>
            </div>
            <div>
                <div class="font-bold">
                    {{ 'RLC 2024 - 2025 Last Generated:' }}
                </div>
                <div>
                    {{ updates['rlc-2025-2027'] ?? 'never' }}
                </div>
            </div>
        </div>
    </XPageLayout>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import PrimeButton from 'primevue/button'
import { XPageLayout , XFormInput } from '@/views/components'

defineProps<{
    updates: Record<string, unknown>
}>()

const Form2025To2027 = useForm({ })
const Form2022To2024 = useForm({ })

/**
 * Generate the 2025 - 2027 RLs.
 * @returns {void}
 */
 const generate2025To2027 = (): void => {
    Form2025To2027.post('/dev/generate-2025-2027')
}
/**
 * Generate the 2022 - 2024 RLs.
 * @returns {void}
 */
const generate2022To2024 = (): void => {
    Form2022To2024.post('/dev/generate-2022-2024')
}
</script>
