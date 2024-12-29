<template>
    <PrimeMessage
        :closable="false"
        icon=""
        severity="info"
    >
        <template #default>
            {{ 'A tool to easily allow you to save your Lioden lions as .png images, with optional background and decorations. Simply enter the full lion url below.' }}
        </template>
    </PrimeMessage>
</template>

<script setup lang="ts">
import PrimeMessage from 'primevue/message'
</script>