<script setup>
import {onMounted} from "vue";
import useTags from "../../../composables/tags.js";
import TagCard from "@/components/TagCard.vue";

const {tags , getTags} = useTags();
onMounted(() => getTags());
</script>

<template>
    <div>
        <h1 class="text-center font-bold text-2xl pb-20">Post List</h1>
        <div class="grid grid-cols-5 gap-4">
            <div class="mt-2" v-for="tag in tags" :key="tag['id']">
                <TagCard :tag="tag"></TagCard>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>

