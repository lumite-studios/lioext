<template>
    <div class="flex flex-col space-y-2">
        <div>
            <label class="block font-medium">{{ 'URL' }} <XRequired /></label>
            <PrimeInputText
                v-model="form.url"
                type="text"
                :pt="{
                    root: '!w-full'
                }"
            />
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center justify-center space-x-2">
                <PrimeCheckbox
                    v-model="form.background"
                    binary
                />
                <label class="block font-medium whitespace-nowrap">{{ 'Background?' }}</label>
            </div>
            <div class="grow text-right italic opacity-60 text-xs">
                {{ 'Include the lions background image.' }}
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center justify-center space-x-2">
                <PrimeCheckbox
                    v-model="form.decorations"
                    binary
                />
                <label class="block font-medium whitespace-nowrap">{{ 'Decorations?' }}</label>
            </div>
            <div class="grow text-right italic opacity-60 text-xs">
                {{ 'Include the lions decorations, if applicable.' }}
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center justify-center space-x-2">
                <PrimeCheckbox
                    v-model="form.cubs"
                    binary
                />
                <label class="block font-medium whitespace-nowrap">{{ 'Nursing Cubs?' }}</label>
            </div>
            <div class="grow text-right italic opacity-60 text-xs">
                {{ 'Include nursing cubs images, if applicable.' }}
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center justify-center space-x-2">
                <PrimeCheckbox
                    v-model="form.opacity"
                    binary
                />
                <label class="block font-medium whitespace-nowrap">{{ '100% Opacity?' }}</label>
            </div>
            <div class="grow text-right italic opacity-60 text-xs">
                {{ 'Show all this lions markings at 100% opacity.' }}
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center justify-center space-x-2">
                <PrimeCheckbox
                    v-model="form.forceAdultMale"
                    binary
                />
                <label class="block font-medium whitespace-nowrap">{{ 'Force Adult Male?' }}</label>
            </div>
            <div class="grow text-right italic opacity-60 text-xs">
                {{ 'Show as an adult male image. NOTE: if a cub/teen this will not include their mutation.' }}
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center justify-center space-x-2">
                <PrimeCheckbox
                    v-model="form.forceAdultFemale"
                    binary
                />
                <label class="block font-medium whitespace-nowrap">{{ 'Force Adult Female?' }}</label>
            </div>
            <div class="grow text-right italic opacity-60 text-xs">
                {{ 'Show as an adult female image.' }}
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3'
import PrimeCheckbox from 'primevue/checkbox'
import PrimeInputText from 'primevue/inputtext'
import { XRequired } from '@/views/components'
import type { Form } from '../image.typings'

const form = defineModel('form', { required: true, type: Object as () => InertiaForm<Form> })
</script>
