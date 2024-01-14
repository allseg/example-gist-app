<script setup lang="ts">
import IconBase from '@/Components/Icons/IconBase.vue';
import Button from '@/Components/Inputs/Button.vue';
import Textarea from '@/Components/Inputs/Textarea.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Gist } from '@/types/types';
import { router, useForm, usePage } from '@inertiajs/vue3';
import hljs from 'highlight.js';
import 'highlight.js/styles/github.css';
import { onMounted, computed, ref } from 'vue';

const props = defineProps<{
    gist: Gist;
    comments: any[];
    isStarred: boolean;
}>();

const user = computed(() => usePage().props.auth.user);
const commentsForm = useForm({
    body: null,
});
const editingCommentId = ref(null as number | null);

async function postComment() {
    commentsForm.post(`/comments/${props.gist.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            commentsForm.reset('body');
        },
    });
}

function editComment(id: number) {
    commentsForm.body = props.comments.find(comment => comment.id === id)?.body;
    editingCommentId.value = id;
}

function cancelEditingComment() {
    editingCommentId.value = null;
    commentsForm.reset('body');
}

function updateComment(id: number) {
    commentsForm.patch(`/comments/${props.gist.id}/${id}`, {
        preserveScroll: true,
        onSuccess: () => {
            commentsForm.reset('body');
            cancelEditingComment();
        },
    });
}

function deleteComment(id: number) {
    router.delete(`/comments/${props.gist.id}/${id}`);
}

async function addStar() {
    router.put(`/starred/${props.gist.id}`);
}

async function removeStar() {
    router.delete(`/starred/${props.gist.id}`);
}
console.log(props.gist, props.comments, user);
onMounted(() => {
    hljs.highlightAll();
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
                        @click="router.get(`/gists/edit/${gist.id}`)"
                        >Edit</Button
                    >
                    <Button
                        v-if="!isStarred"
                        color="blue"
                        @click="addStar"
                        >Star</Button
                    >
                    <Button
                        v-if="isStarred"
                        color="blue"
                        @click="removeStar"
                        >Unstar</Button
                    >
                    <Button
                        color="red"
                        @click="router.delete(`/gists/delete/${gist.id}`)"
                        >Delete</Button
                    >
                </div>

                <template v-for="file in gist.files">
                    <div class="p-5 bg-white overflow-hidden shadow-sm mb-3">
                        <div class="font-bold py-3 text-gray-900">{{ file?.filename }}</div>
                        <pre><code>{{ file?.content }}</code></pre>
                    </div>
                </template>

                <div>
                    <div class="font-bold py-3 text-gray-900">Comments</div>
                    <div
                        class="p-5 bg-white overflow-hidden shadow-sm mb-3"
                        v-for="comment in comments">
                        <div class="">
                            <div v-if="comment.id === editingCommentId">
                                <Textarea
                                    v-model="commentsForm.body"
                                    placeholder="Write comment"
                                    size="200" />
                                <div class="flex gap-3">
                                    <Button
                                        color="green"
                                        @click="updateComment(comment.id)"
                                        >Update comment</Button
                                    >
                                    <Button
                                        color="blue"
                                        @click="cancelEditingComment"
                                        >Cancel</Button
                                    >
                                </div>
                            </div>

                            <div v-else>
                                <div class="flex items-center font-bold py-3 text-gray-900 gap-1">
                                    <a
                                        :href="comment.user.html_url"
                                        target="_blank">
                                        {{ comment.user.login }}
                                    </a>
                                    <div class="text-xs">@</div>
                                    {{ comment.updated_at }}
                                    <IconBase
                                        v-if="comment.user.id === user.github_id"
                                        class="cursor-pointer ml-2"
                                        icon="Edit"
                                        tooltip="Edit comment"
                                        @click="editComment(comment.id)" />
                                    <IconBase
                                        v-if="comment.user.id === user.github_id"
                                        class="cursor-pointer ml-2"
                                        icon="Delete"
                                        tooltip="Delete"
                                        @click="deleteComment(comment.id)" />
                                </div>
                                <div class="font-bold py-3 text-gray-900">
                                    {{ comment.body }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 bg-white overflow-hidden shadow-sm mb-3">
                        <Textarea
                            v-model="commentsForm.body"
                            placeholder="Write comment"
                            size="200" />
                        <Button
                            color="green"
                            @click="postComment"
                            >Comment</Button
                        >
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
