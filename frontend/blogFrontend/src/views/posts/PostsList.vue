<script setup>
import usePosts from "../../../composables/posts.js";
import {onMounted} from "vue";
import PostCard from "@/components/PostCard.vue";

const {posts, getPosts} = usePosts();
onMounted(() => getPosts());
</script>

<template>
    <div>
        <h1 class="text-center font-bold text-2xl pb-20">Post List</h1>
        <div class="flex flex-col gap-2 justify-items-stretch">
            <div class="mb-5" v-for="post in posts" :key="post.id">
                <PostCard class="flex-1" :post="post"></PostCard>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
