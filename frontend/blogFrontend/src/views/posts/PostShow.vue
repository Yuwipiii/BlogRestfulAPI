<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import usePosts from '../../../composables/posts.js';
import Post from '@/components/PostCard.vue';

const route = useRoute();
const { post, getPost } = usePosts();
onMounted( () => getPost(route.params.id));

</script>

<template>
    <div class="">
        <p>{{post['title']}}</p>
    </div>
</template>

<style scoped>
</style>
