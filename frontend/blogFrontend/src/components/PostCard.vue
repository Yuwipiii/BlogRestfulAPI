<script setup>
import router from "@/router/index.js";
import {computed} from "vue";
import usePosts from "../../composables/posts.js";

const emit = defineEmits(['delete']);
const props = defineProps({
    post: {
        required: true,
        type: Object
    }
});


const postStatusClass = computed(() => {
    return props.post['published'] ? 'text-published' : 'text-unpublished';
});

const showPost = () => {
    return router.push({name: 'postShow', params: {id: props.post['id']}});
};
const deletePost =()=>{
    emit('delete',props.post['id']);
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
                    <button @click.stop="deletePost" class="rounded bg-red-600/90 p-2 hover:bg-red-700">
                        Delete
                    </button>
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
