import {createRouter, createWebHistory} from 'vue-router';
import HomeView from '../views/HomeView.vue';
import PostShowView from "../views/posts/PostShowView.vue";
import PostCreateView from "../views/posts/PostCreateView.vue";
import PostEditView from "../views/posts/PostEditView.vue";
import TagsShowView from "../views/tags/TagsShowView.vue";
import TagListView from "../views/tags/TagListView.vue";
import PostsListView from "../views/posts/PostsListView.vue";


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/posts',
            name: 'postsList',
            component: PostsListView
        },
        {
            path: '/posts/:id',
            name: 'postShow',
            component: PostShowView,
        },
        {
            path: '/posts/create',
            name: 'postCreate',
            component: PostCreateView
        },
        {
            path: '/posts/:id/edit',
            name: 'postEdit',
            component: PostEditView
        },
        {
            path: '/tags/:id',
            name: 'tagShow',
            component: TagsShowView
        },
        {
            path: '/tags',
            name: 'tagList',
            component: TagListView
        }
    ]
})

export default router
