<script setup>
import { onMounted, ref } from "vue";
import useTags from "../../../composables/tags.js";
import TagCard from "@/components/TagCard.vue";
import Modal from "@/components/Modal.vue";

const { tags, getTags, destroyTag } = useTags();
onMounted(() => getTags());

const showDeleteModal = ref(false);
const tagToDelete = ref(null);

const openDeleteModal = (tag) => {
    tagToDelete.value = tag;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    tagToDelete.value = null;
};

const handleDelete = async () => {
    if (tagToDelete.value) {
        await destroyTag(tagToDelete.value.id);
        tags.value = tags.value.filter(tag => tag.id !== tagToDelete.value.id);
        closeDeleteModal();
    }
};
</script>

<template>
    <div class="flex justify-center flex-col">
        <h1 class="text-center font-bold text-2xl pb-20">Tag List</h1>
        <table class="border-collapse border border-slate-500 bg-gray-200">
            <thead class="bg-gray-300">
            <tr>
                <th class="border border-slate-600">Tag name</th>
                <th class="border border-slate-600">Number of posts</th>
                <th class="border border-slate-600">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="tag in tags" :key="tag.id">
                <td class="p-5 border border-slate-700">
                    <TagCard :tag="tag"></TagCard>
                </td>
                <td class="border border-slate-700 text-center">{{ tag.posts.length }}</td>
                <td class="border border-slate-700 text-center p-5">
                    <button @click="openDeleteModal(tag)" class="rounded bg-red-600/90 p-2 hover:bg-red-700">
                        Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <Modal :show="showDeleteModal" @close="closeDeleteModal">
            <div class="p-6 bg-gray-600">
                <h2 class="text-lg font-medium text-gray-200">Are you sure you want to delete this tag?</h2>
                <p class="mt-1 text-sm text-gray-200">
                    After deleting the tag, the entire expense history and data associated with the tag will be permanently lost.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button class="rounded bg-gray-400/90 p-2 hover:bg-gray-400" @click="closeDeleteModal">Cancel</button>
                    <button @click="handleDelete" class="rounded bg-red-600/90 p-2 hover:bg-red-700">Delete</button>
                </div>
            </div>
        </Modal>
    </div>
</template>

<style scoped>
</style>
