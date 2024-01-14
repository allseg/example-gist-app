<script setup lang="ts">
import { computed, defineAsyncComponent, ref } from 'vue';
const props = defineProps<{
    icon: string;
    tooltip?: string;
}>();

const iconComponent = computed(() => {
    if (props.icon) {
        // Vite requires the path to be something else than the current.
        return defineAsyncComponent(() => import(`../Icons/${props.icon}.vue`));
    }

    return null;
});

const showTooltip = ref(false);
</script>
<template>
    <div class="relative text-gray-500">
        <div
            v-if="tooltip"
            class="icon-tooltip pointer-events-none absolute z-10 ml-3 -mt-7 rounded p-1.5 text-xs shadow-sm bg-gray-700 text-white"
            :class="{ 'icon-tooltip-active': showTooltip }">
            {{ tooltip }}
        </div>
        <component
            v-if="iconComponent"
            class="w-3.5 h-3.5"
            :is="iconComponent"
            @mouseover="showTooltip = true"
            @mouseleave="showTooltip = false" />
    </div>
</template>
<style>
.icon-tooltip {
    opacity: 0;
    transition: all 0.2s ease-in-out;
    white-space: nowrap;
}
.icon-tooltip-active {
    opacity: 1;
}
</style>
