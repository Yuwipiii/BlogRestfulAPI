<script setup>
import {onMounted} from 'vue';
import {useRoute} from 'vue-router';
import useTags from "../../../composables/tags.js";
import PostCard from "@/components/PostCard.vue";

const route = useRoute();
const {tag, getTag} = useTags();
onMounted(() => getTag(route.params.id));

</script>

<template>
    <div class="">
        <h1 class="text-center font-bold text-3xl">Tag:{{ tag['name'] }}</h1>
        <p class="text-center text-xl font-bold mt-20 mb-5">Post list:</p>
        <div class="flex flex-col gap-2 justify-items-stretch">
            <div class="mb-3" v-for="post in tag['posts']" :key="post.id">
                <PostCard :post="post"></PostCard>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
