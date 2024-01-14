<script setup lang="ts">
defineProps({
    errorMessage: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <div
        class="text-red-500"
        v-if="errorMessage">
        {{ errorMessage }}
    </div>
</template>
