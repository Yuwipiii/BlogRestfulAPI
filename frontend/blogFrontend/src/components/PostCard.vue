<script>
import router from "@/router/index.js";

export default {
    props: [
        'post'
    ],
    methods: {
        showPost() {
            return router.push({name: 'postShow', params: {id: this.post['id']}})
        }
    },
    computed: {
        postStatusClass() {
            return this.post['published'] ? 'text-published' : 'text-unpublished';
        }
    }
}
</script>

<template>
    <div @click="showPost" class="rounded shadow-lg px-6 pt-4 pb-2">
        <div>
            <div class="font-bold text-xl mb-2">{{ post['title'] }}</div>
            <p class="text-gray-700 text-base truncate">
                {{ post['content'] }}
            </p>
            <div class="rounded bg-gray-400 p-2 flex justify-items-stretch">
                <p>Status:</p>
                <p :class="postStatusClass">  {{ post['published'] ? "Published" : "Unpublished" }}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
.text-published {
    color: black; /* Default color for published posts */
}

.text-unpublished {
    color: red; /* Change this to the color you want for unpublished posts */
}
</style>

<style scoped>
</style>
