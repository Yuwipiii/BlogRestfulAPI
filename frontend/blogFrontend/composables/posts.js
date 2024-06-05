import {ref} from 'vue';
import axios from "axios";
axios.defaults.baseURL = "http://127.0.0.1:8000/api/v1/"

export default function usePosts(){
    const posts = ref([]);
    const post = ref([]);

    const getPosts = async ()=>{
        const response =  await axios.get('admin/posts');
        posts.value = response.data;
    }

    const getPost = async (id)=>{
        const response = await axios.get('admin/posts/'+id);
        post.value = response.data
    }
    return {
        post,
        posts,
        getPosts,
        getPost
    }
}
