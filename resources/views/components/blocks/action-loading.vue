<template>
    <div
        :class="[
            'h-full flex items-center justify-center transition-all duration-500',
            { 'opacity-0': message === null, 'opacity-50': message !== null }
        ]"
    >
        <span v-if="message !== null">{{ message }}...</span>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'

const messages: string[] = [
    'Reticulating Splines',
    'Loading Lions',
    'Eating Zebra Heart',
    'Hoarding Golden Beetles',
    'Battling Beetles',
    'Patrolling Sub-Males',
    'Barking Hybrids',
    'Waiting for Jaglions',
    'Gaining MORE Scars',
    'Randomly Applying Markings',
    'Demanding Mutations',
    'Chasing Poachers',
    'Balls',
    'Lab Testing Frogs',
    'Raising Impression',
]

const message = ref<null|string>('')
const timer = ref<null|number>(null)

const startMessages = () => {
    flashMessage()
    timer.value = setInterval(() => flashMessage(), 2000)
}
const flashMessage = () => {
    message.value = null
    setTimeout(() => {
        message.value = messages[Math.floor(Math.random() * messages.length)]
    }, 200)
}

onMounted(() => {
    startMessages()
})
</script>
