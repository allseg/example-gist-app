<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Gist } from '@/types/types';
import { router, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/Inputs/TextInput.vue';
import Textarea from '@/Components/Inputs/Textarea.vue';
import Button from '@/Components/Inputs/Button.vue';
import FormError from '@/Components/Inputs/FormError.vue';
import uuid4 from 'uuid4';
import { computed } from 'vue';

const props = defineProps<{
    gist: Gist;
}>();

const form = useForm({
    description: props.gist.description,
    public: false,
    files: props.gist.files,
});

function addFile() {
    form.files[`new-${uuid4()}`] = { filename: '', content: '' };
}

function deleteFile(key) {
    if (form.files[key]) {
        form.files[key] = null;
    }
}

function submit() {
    Object.keys(form.files).forEach(key => {
        if (!form.files[key] && key.slice(0, 4) === 'new-') {
            delete form.files[key];
        }
    });

    form.patch(`/gists/update/${props.gist.id}`, {
        onError: () => {
            setTimeout(() => {
                form.clearErrors();
            }, 1500);
        },
    });
}

const filesCount = computed(() => {
    let count = 0;
    Object.values(form.files).forEach(value => {
        if (value) {
            count++;
        }
    });

    return count;
});
</script>
<template>
    <AuthenticatedLayout>
        <template #header>{{ gist.description }}</template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-8">
                <div class="flex gap-3 justify-end mb-4">
                    <Button
                        color="green"
                        @click="submit"
                        >Update</Button
                    >
                    <Button
                        color="blue"
                        @click="addFile"
                        >Add file</Button
                    >
                    <Button
                        color="blue"
                        @click="router.get(`/gists/show/${props.gist.id}`)"
                        >Back</Button
                    >
                </div>

                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <TextInput
                            v-model="form.description"
                            placeholder="Description" />
                        <FormError :errorMessage="form.errors['description']"></FormError>
                    </div>

                    <div class="mb-4">
                        <p class="text-gray-700 text-sm font-bold mb-2">Files</p>
                        <FormError :errorMessage="form.errors['files']"></FormError>
                        <div
                            class="mb-4"
                            v-for="(file, key) in form.files">
                            <div v-if="file">
                                <div class="mb-2">
                                    <div class="flex gap-3">
                                        <TextInput
                                            v-model="file.filename"
                                            placeholder="Filename" />

                                        <Button
                                            color="red"
                                            @click="deleteFile(key)"
                                            :disabled="filesCount === 1"
                                            >Remove</Button
                                        >
                                    </div>
                                    <FormError
                                        :errorMessage="
                                            form.errors[`files.${key}.filename`]
                                        "></FormError>
                                </div>
                                <Textarea
                                    v-model="file.content"
                                    placeholder="Code"></Textarea>
                                <FormError
                                    :errorMessage="form.errors[`files.${key}.content`]"></FormError>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
