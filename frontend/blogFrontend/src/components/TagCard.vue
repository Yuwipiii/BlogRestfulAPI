<script setup>
import router from "@/router/index.js";

const props = defineProps({
    'tag':{
        required:true
    }
})
const showTag = async (id) =>{
    return await router.push({name: 'tagShow', params: {id: id}})
}
</script>

<template>
    <span @click="showTag(tag.id)" class="rounded-2xl bg-gray-400 p-3 hover:bg-gray-300">#{{ tag['name'] }}</span>
</template>

<style scoped>

</style>
