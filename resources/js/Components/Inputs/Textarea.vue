<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    modelValue: string | null | undefined;
    placeholder?: string;
    size?: string;
}>();
const emit = defineEmits(['update:modelValue']);
const size = computed(() => (props.size ? `h-[${props.size}px]` : 'h-[450px]'));
</script>

<template>
    <textarea
        class="form-textarea w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        :class="size"
        :value="modelValue"
        :placeholder="placeholder"
        @input="$event => emit('update:modelValue', $event.target.value)"></textarea>
</template>
