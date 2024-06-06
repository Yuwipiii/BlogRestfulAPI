import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import PostsList from "@/views/posts/PostsList.vue";
import PostShow from "@/views/posts/PostShow.vue";
import TagsShow from "@/views/tags/TagsShow.vue";
import TagList from "@/views/tags/TagList.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
          path:'/posts',
            name:'postList',
            component:PostsList
        },
        {
            path:'/posts/:id',
            name:'postShow',
            component:PostShow,
        },
        {
            path:'/tags/:id',
            name:'tagShow',
            component:TagsShow
        },
        {
            path:'/tags',
            name:'tagList',
            component:TagList
        }
    ]
})

export default router
