<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps<{
    error: any;
}>();
</script>

<template>
    <AuthenticatedLayout>
        <template #header>Error: {{ error }}</template>
    </AuthenticatedLayout>
</template>
