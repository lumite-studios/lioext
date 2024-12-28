<template>
    <div class="h-screen w-screen overflow-y-auto bg-surface-200 dark:bg-surface-800">
        <div class="h-header bg-primary-400">
            <div class="pt-6 text-center">
                <XLinkInternal href="/">
                    <XHeading
                        class="text-white"
                        content="LioExt"
                        level="1"
                    />
                </XLinkInternal>
            </div>
            <div class="px-3 md:px-6">
                <ToolbarPartial />
            </div>
        </div>
        <div class="-mt-32 p-3 md:p-6">
            <div class="min-h-header rounded-md bg-white p-3 shadow md:p-6">
                <slot />
            </div>
        </div>
        <FooterPartial />
    </div>
</template>

<script setup lang="ts">
import { XHeading, XLinkInternal } from '@/views/components'
import { FooterPartial, ToolbarPartial } from './_components'
</script>
