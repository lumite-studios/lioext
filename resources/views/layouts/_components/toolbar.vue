<template>
    <PrimeToolbar
        :pt="{
            root: '!bg-transparent !border-transparent'
        }"
    >
        <template #center>
            <div class="flex space-x-2">
                <XLinkInternal href="/">
                    <PrimeButton
                        label="Home"
                        size="small"
                    />
                </XLinkInternal>
                <XLinkInternal href="/image">
                    <PrimeButton
                        label="LioImage"
                        size="small"
                    />
                </XLinkInternal>
                <XLinkInternal href="/rlc">
                    <PrimeButton
                        label="LioRLC"
                        size="small"
                    />
                </XLinkInternal>
                <XLinkInternal
                    v-if="env === 'local'"
                    href="/dev"
                >
                    <PrimeButton
                        label="DEV"
                        size="small"
                    />
                </XLinkInternal>
            </div>
        </template>
    </PrimeToolbar>
</template>

<script setup lang="ts">
import PrimeButton from 'primevue/button'
import PrimeToolbar from 'primevue/toolbar'
import { XLinkInternal } from '@/views/components'
</script>
