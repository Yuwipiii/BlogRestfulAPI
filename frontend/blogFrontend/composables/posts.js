import {ref} from 'vue';
import axios from "axios";
import router from "@/router/index.js";
import {useRouter} from "vue-router";
import {data} from "autoprefixer";
axios.defaults.baseURL = "http://127.0.0.1:8000/api/v1/"

export default function usePosts(){
    const posts = ref([]);
    const post = ref([]);
    const errors = ref([]);
    const router = useRouter();

    const getPosts = async ()=>{
        const response =  await axios.get('admin/posts');
        posts.value = response.data;
    }

    const storePost = async (data)=>{
        try{
            await axios.post('admin/posts',data);
            await router.push({name:'postsList'});
        }catch (error){
            if(error.response.status === 422){
                errors.value = error.response.data.errors;
            }
        }
    }
    const updatePost = async (data)=>{

    }

    const getPost = async (id)=>{
        const response = await axios.get('admin/posts/'+id);
        post.value = response.data
    }
    const destroyPost = async (id)=>{
        await axios.delete('admin/posts/'+id);
    }
    return {
        post,
        posts,
        getPosts,
        getPost,
        destroyPost
    }
}
