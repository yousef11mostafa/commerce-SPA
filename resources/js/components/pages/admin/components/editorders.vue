
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
            <label for="name" class="form-label">order total</label>
            <input type="text" id="name" class="form-control" v-model="data.total">
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

const dialogVisible = ref(false)
const store=useStore();


import { defineProps , defineEmits } from 'vue';

const props = defineProps({
  order: Object
});


const data=reactive({
     total:'',

});

onMounted(() => {
  data.total = props.order.total;
});

const products=ref([]);
const emit = defineEmits(['updateEvent']);
const error=ref('');



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

