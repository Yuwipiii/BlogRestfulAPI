<script setup>
import {RouterLink, RouterView} from 'vue-router'
</script>

<template>
    <header class="bg-gray-400">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="flex justify-start gap-3 p-5">
                <RouterLink to="/">Home</RouterLink>
                <RouterLink to="/posts">Posts</RouterLink>
            </nav>
        </div>
    </header>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-20">
        <RouterView/>
    </div>
</template>
