import {ref} from 'vue';
import axios from "axios";
axios.defaults.baseURL = "http://127.0.0.1:8000/api/v1/";
export default function useTags(){
    const tags = ref([]);
    const tag = ref([]);

    const getTags = async ()=>{
        const response = await axios.get('admin/tags');
        tags.value = response.data;
    }

    const getTag = async (id)=>{
        const response = await axios.get('admin/tags/'+id);
        tag.value= response.data;
    }
    const destroyTag = async (id)=>{
        await axios.delete('admin/tags/'+id);
        tags.value = tags.value.filter(p => p.id !== id);
    }

    return{
        tag,
        tags,
        getTag,
        getTags,
        destroyTag
    }
}
