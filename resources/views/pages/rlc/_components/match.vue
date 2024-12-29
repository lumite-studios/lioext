<template>
    <div class="rounded overflow-hidden border border-surface-100">
        <img :src="match.image">
        <div class="p-3">
            <div class="flex justify-between items-center">
                <div class="font-bold">
                    {{ datetime(match.date).format('Do MMMM YYYY') }}
                </div>
                <div class="text-sm opacity-75 text-center">
                    {{ Math.round(match.percent) }}%
                </div>
            </div>
            <div class="grid grid-cols-2 gap-1 text-sm mt-2 border-t pt-2 border-surface-200">
                <div
                    v-for="part in match.matches"
                    :key="part"
                >
                    <div class="font-bold">
                        {{ part }}
                    </div>
                    {{ getMatchPart(match, part) }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {datetime} from '@/js/plugins/datetime'
import { type Match, type Parts } from '../rlc.typings'

defineProps<{
    match: Match
}>()

const getMatchPart = (match: Match, part: keyof Parts): string => {
    if(part === 'Base') {
        return match.Base.split('(')[0]
    }
    if(part === 'Skin') {
        return match.Base.split('(')[1].replace(')', '')
    }
    if(part === 'Mane Type') {
        return match.Mane.split(' ')[0]
    }
    if(part === 'Mane Color') {
        return match.Mane.split(' ')[1]
    }
    if(part.includes('Slot')) {
        const slot = part.split(' ', 2).join(' ')
        return match[slot].split(' (')[0]
    }
    return match[part] ?? ''
}
</script>
