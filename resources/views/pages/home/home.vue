<template>
    <Head :title="'Home'" />
    <div class="flex flex-col space-y-6">
        <NavigationPartial />
        <div class="border-t pt-6 border-surface-200">
            <XHeading content="News" />
            <div class="grid grid-cols-3 gap-12">
                <div
                    v-for="(post, index) in posts"
                    :key="index"
                >
                    {{ post.content }}
                    <div class="font-medium opacity-50 text-sm">
                        {{ post.created_at }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { XHeading } from '@/views/components'
import { NavigationPartial } from './_components'

defineProps<{
    local: boolean,
    posts: { content: string, created_at: string }[]
}>()
</script>
