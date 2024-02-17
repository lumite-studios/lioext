<template>
    <div class="h-screen w-screen overflow-y-auto bg-surface-50 dark:bg-surface-800">
        <div class="h-header bg-primary-400">
            <div class="pt-6 text-center">
                <Link href="/">
                    <Heading class="text-white" content="LioExt" level="1" />
                </Link>
            </div>
            <div class="px-3 md:px-6">
                <Toolbar class="border-primary-600">
                    <template #center>
                        <Link href="/image">
                            <Button label="LioImage" />
                        </Link>
                    </template>
                </Toolbar>
            </div>
        </div>
        <div class="-mt-32 p-3 md:p-6">
            <div class="min-h-header rounded-md bg-white p-3 shadow md:p-6">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Button from 'primevue/button'
import Toolbar from 'primevue/toolbar'
import { Heading } from '@/components'
</script>
