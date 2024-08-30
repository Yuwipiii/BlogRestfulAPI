<script setup>
import usePosts from "../../../composables/posts.js";
import {onMounted} from "vue";
import PostCard from "@/components/PostCard.vue";
import router from "@/router/index.js";

const {posts, getPosts, destroyPost} = usePosts();
onMounted(() => getPosts());
const handleDelete = async (id) => {
    await destroyPost(id);
    posts.value = posts.value.filter(post => post.id !== id);
}

const createPost = async () => {
    return await router.push({name: 'postCreate'});
}
</script>

<template>
    <div>
        <h1 class="text-center font-bold text-2xl pb-20">Post List</h1>
        <button @click="createPost"
                class="rounded bg-green-600/90 p-2 hover:bg-green-700">
            Create
        </button>
        <div class="flex flex-col gap-2 justify-items-stretch mt-5">
            <PostCard
                v-for="post in posts"
                :key="post.id"
                @delete="handleDelete"
                class="flex-1" :post="post"></PostCard>
        </div>
    </div>
</template>

<style scoped>
</style>
