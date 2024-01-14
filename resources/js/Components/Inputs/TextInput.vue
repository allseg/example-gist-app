<script setup lang="ts">
defineProps<{
    modelValue: string;
    placeholder?: string;
}>();
const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <input
        :value="modelValue"
        class="form-input block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        type="text"
        :placeholder="placeholder"
        @input="$event => emit('update:modelValue', $event.target.value)" />
</template>
