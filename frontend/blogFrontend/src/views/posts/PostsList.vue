<script setup>
import usePosts from "../../../composables/posts.js";
import { onMounted} from "vue";

const {posts,getPosts} = usePosts();
onMounted(()=>getPosts());
</script>

<template>
    <div>
        <h1>Post list</h1>
        <div>
            <div v-for="post in posts" :key="post.id">
                <p>{{post.title}}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
