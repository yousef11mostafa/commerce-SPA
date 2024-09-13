
<template>
  <!-- <el-button plain @click="dialogVisible = true">
    Click to open the Dialog
  </el-button> -->

  <button class="btn  btn-info" @click="dialogVisible=true">edit</button>

  <el-dialog
    v-model="dialogVisible"
    title="Tips"
    width="500"
    :before-close="handleClose"
  >

     <form action="" @submit.prevent="update()">
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
            <textarea name="price" class="form-control" id="price" v-model="data.price"></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">update</button>
     </form>
    <template #footer>
      <div class="dialog-footer">
        <el-button @click="dialogVisible = false , error=null">Cancel</el-button>
        <el-button type="primary" @click="dialogVisible = false , error=null ">
          Confirm
        </el-button>
      </div>
    </template>
  </el-dialog>
</template>

<script lang="ts" setup>
import { ref ,reactive, onMounted } from 'vue'
import { ElMessageBox } from 'element-plus'
import axiosInstance from '../../../../axios';
import { useStore } from 'vuex';

const router=useRouter();

const dialogVisible = ref(false)
const store=useStore();


import { defineProps , defineEmits } from 'vue';
import { useRouter } from 'vue-router';


const props = defineProps({
  product: Object
});


const data=reactive({
     name:'',
     description:'',
     price:'',

});

onMounted(() => {
  data.name = props.product.name;
  data.description = props.product.description;
  data.price = props.product.price;
});

const products=ref([]);
const emit = defineEmits(['updateEvent']);
const error=ref('');

const update=async()=>{
   try{
         await axiosInstance.put(`v1/products/${props.product.slug}`,data);

            const response=await axiosInstance.get('user/getproducts');

            products.value=response.data;
            emit('updateEvent', products.value);
            dialogVisible.value=false;

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

