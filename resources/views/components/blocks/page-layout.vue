<template>
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row md:space-x-6">
        <div class="md:w-1/3 md:shrink-0">
            <div class="flex flex-col space-y-3 rounded-md border border-surface-100 p-3 md:p-6">
                <slot name="sidebar" />
            </div>
        </div>
        <div class="grow">
            <slot name="default" />
        </div>
    </div>
</template>
