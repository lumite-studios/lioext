<template>
    <div class="flex flex-col space-y-6">
        <div class="grid grid-cols-3 mx-auto max-w-4xl gap-6">
            <Link href="/image">
                <img src="/images/lioimage.jpg" />
            </Link>
        </div>
        <div class="border-t pt-6">
            <Heading content="News" />
            <div class="grid grid-cols-3">
                <div v-for="post in posts">
                    {{ post.content }}
                    <div class="font-medium opacity-50 text-sm">{{ post.date }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { Heading } from '@/components'
import { posts } from '@/data/news'
</script>
