import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import PostsList from "@/views/posts/PostsList.vue";
import PostShow from "@/views/posts/PostShow.vue";

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
        }
    ]
})

export default router
