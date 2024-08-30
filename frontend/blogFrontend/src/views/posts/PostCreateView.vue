<script setup>
import {onMounted, reactive} from "vue";
import usePosts from "../../../composables/posts.js";
import router from "@/router/index.js";

const {storePost} = usePosts();
const form = reactive({
    title: "",
    content: ""
})
const createPost = async (form) => {
    console.log(form.value);
    return await router.push({name: 'postsList'})
}
</script>

<template>
    <form>
        <div>
            <label class="block">
  <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
    Title
  </span>
                <input type="text" name="title"
                       class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1"
                       placeholder="you@example.com"/>
            </label>
        </div>

        <div class="mt-2">
            <label class="block">
  <span class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-slate-700">
    Content
  </span>
                <textarea class="resize rounded-md border-2 mt-2" name="content" rows="5" cols="30">

                </textarea>
            </label>
        </div>

        <button class="rounded bg-green-600/90 p-2 hover:bg-green-700" @click="createPost">Submit</button>
    </form>
</template>

<style scoped>

</style>
