<script setup>
import router from "@/router/index.js";
import {computed, ref} from "vue";
import Modal from "@/components/Modal.vue";

const emit = defineEmits(['delete']);
const props = defineProps({
    post: {
        required: true,
        type: Object
    }
});

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


const postStatusClass = computed(() => {
    return props.post['published'] ? 'text-published' : 'text-unpublished';
});

const showPost = () => {
    return router.push({name: 'postShow', params: {id: props.post['id']}});
};
const deletePost = () => {
    emit('delete', props.post['id']);
}
</script>

<template>
    <div @click="showPost()" class="rounded shadow-md bg-gray-100 px-6 pt-4 pb-2">
        <div>
            <div class="font-bold text-xl mb-2">#{{ post['id'] + " " + post['title'] }}</div>
            <p class="text-gray-700 text-base truncate">
                {{ post['content'] }}
            </p>
            <div class="flex justify-between">
                <div class="rounded bg-gray-400 p-2 flex justify-items-stretch">
                    <p>Status:</p>
                    <p :class="postStatusClass"> {{ post['published'] ? "Published" : "Unpublished" }}</p>
                </div>
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
                                <button @click="deletePost" class="rounded bg-red-600/90 p-2 hover:bg-red-700">Delete
                                </button>
                            </div>
                        </div>
                    </Modal>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>
.text-published {
    color: black; /* Default color for published posts */
}

.text-unpublished {
    color: red; /* Change this to the color you want for unpublished posts */
}
</style>
