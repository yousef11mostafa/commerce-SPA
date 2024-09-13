
<template>
  <!-- <el-button plain @click="dialogVisible = true">
    Click to open the Dialog
  </el-button> -->

  <div>
      <button class="btn  btn-primary" @click="dialogVisiblee=true">new Product</button>

  <el-dialog
    v-model="dialogVisiblee"
    title="Tips"
    width="500"
    :before-close="handleClose"
  >

     <form action="" @submit.prevent="create()">
        <!-- {{ categories }} -->
        <p class="text-danger text-center" v-if="error">{{error.message}}</p>
        <div class="form-group">
            <label for="name" class="form-label">product name</label>
            <input type="text" id="name" class="form-control" v-model="data.name">
        </div>
        <div class="form-group">
            <label for="desc" class="form-label">product description</label>
            <textarea name="desc" class="form-control" id="desc" v-model="data.description"></textarea>
        </div>
        <div class="form-group">
            <label for="price" class="form-label">product price</label>
            <input name="price" class="form-control" id="price" v-model="data.price">
        </div>
        <div class="form-group">
            <label for="price" class="form-label">category</label>
            <select name="user" id="category" class="form-select" v-model="data.category_id">
                <option v-for="category in categories" :key="category" :value="category.id" for="category">{{category.name}}</option>

            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">create</button>
     </form>
    <template #footer>
      <div class="dialog-footer">
        <el-button @click="dialogVisiblee = false , error=null">Cancel</el-button>
        <el-button type="primary" @click="dialogVisiblee = false , error=null ">
          Confirm
        </el-button>
      </div>
    </template>
  </el-dialog>
  </div>


</template>

<script lang="ts" setup>
import { ref ,reactive, onMounted } from 'vue'
import { ElMessageBox } from 'element-plus'
import axiosInstance from '../../../../axios';
import { useStore } from 'vuex';

const dialogVisiblee = ref(false)
const store=useStore();


import { defineProps , defineEmits } from 'vue';

const categories=ref([]);

const fetchcategoies=async()=>{
    try{
       const response= await axiosInstance.get("categories");
       categories.value=response.data;
    }catch(e){
        console.log("failed to fetch categoires in create product"+e);
    }
}

onMounted(()=>{
    fetchcategoies();
})

const data=reactive({
     name:'',
     description:'',
     price:'',
     category_id:'',

});


const products=ref([]);

const emit = defineEmits(['createEvent']);
const error=ref('');

const create=async()=>{
   try{
         await axiosInstance.post(`v1/products`,data);
            const response=await axiosInstance.get('user/getproducts');
            products.value=response.data;
            emit('createEvent', products.value);
            alert("post created successfylly");
            dialogVisiblee.value=false;

   }catch(e){
    console.log("eror in updating the product"+e);
      error.value=e.response.data;
   }


}





const handleClose = (done: () => void) => {
  ElMessageBox.confirm('Are you sure to close this dialog?')
    .then(() => {
      done()
    })
    .catch(() => {
      // catch error
    })
}
</script>

