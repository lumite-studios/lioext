<template>
    <PrimeMessage
        :closable="false"
        icon=""
        severity="info"
    >
        <template #default>
            {{ 'See if your lion is a Raffle Lion Clone (RLC), by checking if it matches a Raffle Lion from previous years.' }}
        </template>
    </PrimeMessage>
</template>

<script setup lang="ts">
import PrimeMessage from 'primevue/message'
</script>
