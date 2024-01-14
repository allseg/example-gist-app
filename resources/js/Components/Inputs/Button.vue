<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    color: string;
    disabled?: boolean;
}>();

const colorClass = computed(() => {
    switch (props.color) {
        case 'green':
            return 'bg-green-500 hover:bg-green-700';
        case 'blue':
            return 'bg-blue-500 hover:bg-blue-700';
        case 'red':
            return 'bg-red-500 hover:bg-red-700';
    }
});
</script>
<template>
    <button
        class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        :class="[colorClass, { 'opacity-50 cursor-not-allowed': disabled }]"
        type="button"
        :disabled="disabled">
        <slot></slot>
    </button>
</template>
