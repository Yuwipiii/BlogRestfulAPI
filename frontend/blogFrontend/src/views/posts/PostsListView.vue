<script setup>
import usePosts from "../../../composables/posts.js";
import {onMounted} from "vue";
import PostCard from "@/components/PostCard.vue";

const {posts, getPosts,destroyPost} = usePosts();
onMounted(() => getPosts());
const handleDelete = async (id)=>{
    await destroyPost(id);
    posts.value = posts.value.filter(post => post.id !== id);
}
</script>

<template>
    <div>
        <h1 class="text-center font-bold text-2xl pb-20">Post List</h1>
        <div class="flex flex-col gap-2 justify-items-stretch">
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
