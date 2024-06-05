<script setup>
import usePosts from "../../../composables/posts.js";
import {onMounted} from "vue";
import PostCard from "@/components/PostCard.vue";

const {posts, getPosts} = usePosts();
onMounted(() => getPosts());
</script>

<template>
    <div>
        <h1>Post list</h1>
        <div class="grid grid-cols-3 gap-1">
            <div v-for="post in posts" :key="post.id">
                <PostCard class="col-span-1" :post="post"></PostCard>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
