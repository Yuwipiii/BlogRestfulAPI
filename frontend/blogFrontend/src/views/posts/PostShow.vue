<script setup>
import {onMounted} from 'vue';
import {useRoute} from 'vue-router';
import usePosts from '../../../composables/posts.js';
import TagCard from "@/components/TagCard.vue";

const route = useRoute();
const {post, getPost} = usePosts();
onMounted(() => getPost(route.params.id));

</script>

<template>
    <div class="">
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
