<template>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row md:space-x-6">
        <div class="md:w-1/3">
            <div class="flex flex-col space-y-3 rounded-md border border-surface-100 p-3 md:p-6">
                <Message
                    :closable="false"
                    icon=""
                    severity="error"
                >
                    <template #default>
                        <div class="text-lg font-medium">
                            Notice:
                        </div>
                        It is currently NOT possible to generate images from the wardrobe as these require being logged in.
                    </template>
                </Message>
                <Message
                    :closable="false"
                    icon=""
                    severity="info"
                >
                    <template #default>
                        A tool to easily allow you to save your Lioden lions as .png images, with optional background and decorations. Simply enter the full lion url below.
                    </template>
                </Message>
                <div class="flex flex-col space-y-1">
                    <label class="block font-medium">URL</label>
                    <InputText
                        v-model="form.url"
                        type="text"
                    />
                    <div class="flex items-center justify-center space-x-2">
                        <Checkbox v-model="form.background" :binary="true" />
                        <label class="block font-medium">Include background?</label>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <Checkbox v-model="form.decorations" :binary="true" />
                        <label class="block font-medium">Include decorations?</label>
                    </div>
                    <div class="flex items-center justify-center space-x-2">
                        <Checkbox v-model="form.opacity" :binary="true" />
                        <label class="block font-medium">Show at 100% opacity?</label>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="grow font-medium">
                        <span v-if="form.processing">THIS MAY TAKE SOME TIME, PLEASE BE PATIENT!</span>
                    </div>
                    <Button
                        label="Generate"
                        :loading="form.processing"
                        @click="generate"
                    />
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center grow">
            <div
                :class="[
                    'transition-all duration-500',
                    { 'opacity-0': message === null },
                    { 'opacity-50': message !== null }
                ]"
                v-if="form.processing"
            >
                <span v-if="message !== null">{{ message }}...</span>
            </div>
            <img :src="image" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import InputText from 'primevue/inputtext'
import Message from 'primevue/message'
import { messages } from './image.typings'

const props = defineProps({
    base64: {
        type: String,
        default: null
    }
})

const form = useForm({
    url: 'https://www.lioden.com/lion.php?mid=96301',
    background: false,
    decorations: false,
    opacity: false,
})
const image = ref<null|string>(props.base64)
const message = ref<string>('')
const timer = ref<null|number>(null)

const generate = () => {
    image.value = null
    form.post('/image', {
        only: ['base64'],
        onStart: startMessages,
        onFinish: () => {
            stopMessages()
        }
    })
}
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
const stopMessages = () => {
    clearInterval(timer.value)
}

watch(props, () => image.value = props.base64)
</script>
