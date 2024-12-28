<template>
    <div class="bg-surface-200 text-center text-sm px-3 md:px-6">
        {{ 'Website &copy;' }}
        <XLinkExternal
            class="text-primary-500"
            href="https://lumitestudios.com"
        >
            {{ 'Lumite Studios' }}
        </XLinkExternal>.
        {{ 'Art assets including Lioden logo &copy;' }}
        <XLinkExternal
            class="text-primary-500"
            href="https://www.lioden.com"
        >
            {{ 'Lioden' }}
        </XLinkExternal>.
        <br>
        <XLinkExternal
            class="inline-block mt-3"
            href="https://www.lioden.com"
        >
            <img
                class="w-20"
                src="https://static.lioden.com/img/layout/logo-full-2.png"
            >
        </XLinkExternal>
    </div>
</template>

<script setup lang="ts">
import { XLinkExternal } from '@/views/components'
</script>
