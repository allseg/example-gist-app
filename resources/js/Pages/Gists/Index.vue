<script setup lang="ts">
import IconBase from '@/Components/Icons/IconBase.vue';
import Button from '@/Components/Inputs/Button.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Gist } from '@/types/types';
import { Link, router } from '@inertiajs/vue3';

defineProps<{
    gists: Gist[];
}>();
</script>
<template>
    <AuthenticatedLayout>
        <template #header>Gists</template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-3 justify-end mb-4">
                    <Button
                        color="green"
                        @click="router.get('/gists/create')"
                        >New gist</Button
                    >
                </div>

                <div class="bg-white shadow-sm">
                    <div
                        class="p-2 text-gray-900"
                        v-for="gist in gists">
                        <div class="flex items-center gap-4">
                            <Link :href="route('gists.show', gist.id)">{{
                                Object.values(gist.files)[0]?.filename
                            }}</Link>
                            <div class="flex gap-1 items-center text-gray-700">
                                <IconBase
                                    icon="File"
                                    tooltip="Files" />
                                <span class="text-sm">{{ Object.keys(gist.files).length }}</span>
                            </div>
                            <div class="flex gap-1 items-center text-gray-700">
                                <IconBase
                                    icon="Comment"
                                    tooltip="Comments" />
                                <span class="text-sm">{{ gist.comments }}</span>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="gists.length === 0"
                        class="p-2 text-gray-900">
                        No gists found
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
