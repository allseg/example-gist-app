<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/Inputs/TextInput.vue';
import Textarea from '@/Components/Inputs/Textarea.vue';
import Button from '@/Components/Inputs/Button.vue';
import FormError from '@/Components/Inputs/FormError.vue';
import uuid4 from 'uuid4';
import { computed } from 'vue';
import { Gist } from '@/types/types';

const form = useForm({
    description: '',
    public: false,
    files: {} as Gist['files'],
});

function addFile() {
    form.files[uuid4()] = { filename: '', content: '' };
}
addFile();

function deleteFile(key) {
    if (form.files[key]) {
        form.files[key] = null;
    }
}

function submit() {
    Object.keys(form.files).forEach(key => {
        if (!form.files[key]) {
            delete form.files[key];
        }
    });

    form.post('/gists/store', {
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
        <template #header>Create new gist</template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex gap-3 justify-end mb-4">
                    <Button
                        color="green"
                        @click="submit"
                        >Create</Button
                    >
                    <Button
                        color="blue"
                        @click="addFile"
                        >Add file</Button
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
                                            >Delete</Button
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
