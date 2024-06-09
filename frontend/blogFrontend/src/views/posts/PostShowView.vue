<script setup>
import {onMounted, ref} from 'vue';
import {useRoute} from 'vue-router';
import usePosts from '../../../composables/posts.js';
import TagCard from "@/components/TagCard.vue";
import router from "@/router/index.js";
import Modal from "@/components/Modal.vue";

const route = useRoute();
const {post, getPost, destroyPost} = usePosts();
onMounted(() => getPost(route.params.id));
const deletePost = async (id) => {
    await destroyPost(id)
    return router.push({name: 'postList'});
}

const showDeleteModal = ref(false);
const postToDelete = ref(null);

const openDeleteModal = (post) => {
    postToDelete.value = post;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    postToDelete.value = null;
};


</script>

<template>
    <div>
        <button @click.stop="openDeleteModal(post['id'])"
                class="rounded bg-red-600/90 p-2 hover:bg-red-700">
            Delete
        </button>
        <Modal :show="showDeleteModal" @close="closeDeleteModal">
            <div class="p-6 bg-gray-600">
                <h2 class="text-lg font-medium text-gray-200">Are you sure you want to delete this
                    post?</h2>
                <p class="mt-1 text-sm text-gray-200">
                    After deleting the post, data associated with the post will be permanently lost.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button class="rounded bg-gray-400/90 p-2 hover:bg-gray-400" @click="closeDeleteModal">
                        Cancel
                    </button>
                    <button @click="deletePost(post['id'])" class="rounded bg-red-600/90 p-2 hover:bg-red-700">Delete
                    </button>
                </div>
            </div>
        </Modal>
        <h1 class="text-center font-bold text-3xl">{{ post['title'] }}</h1>
        <p class="text-start text-xl mt-20">{{ post['content'] }}</p>
    </div>
    <div class="pt-20 flex gap-3 justify-items-start">
        <div v-for="tag in post['tags']">
            <TagCard :tag="tag"></TagCard>
        </div>
    </div>

</template>

<style scoped>
</style>
