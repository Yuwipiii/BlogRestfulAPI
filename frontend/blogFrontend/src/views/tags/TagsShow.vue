<script setup>
import {onMounted} from 'vue';
import {useRoute} from 'vue-router';
import useTags from "../../../composables/tags.js";
import PostCard from "@/components/PostCard.vue";
import usePosts from "../../../composables/posts.js";

const route = useRoute();
const {tag, getTag} = useTags();
const {destroyPost} = usePosts()
onMounted(() => getTag(route.params.id));
const handleDelete = async (id)=>{
    await destroyPost(id);
    tag.value.posts = tag.value.posts.filter(post => post.id !== id);
}
</script>

<template>
    <div class="">
        <h1 class="text-center font-bold text-3xl">Tag:{{ tag['name'] }}</h1>
        <p class="text-center text-xl font-bold mt-20 mb-5">Post list:</p>
        <div class="flex flex-col gap-2 justify-items-stretch">
            <PostCard
                v-for="post in tag['posts']"
                :key="post.id"
                @delete="handleDelete"
                class="flex-1" :post="post"></PostCard>
        </div>
    </div>
</template>

<style scoped>
</style>
