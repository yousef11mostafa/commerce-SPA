
import axios from 'axios';

import  AxiosInstance  from '../../axios'

export default{
    namespaced:true,

    state:{
       error:null,
       orders:[],
    },
    getters:{
        getorders(state){
            return state.orders;
        },


    },
    mutations:{
        setorders(state,orders){
        state.orders=orders;
      }



    },
    actions:{
         async getorders(context){
             const response=await AxiosInstance.get("admin/orders");
             context.commit('setorders',response.data);
         },
         async deleteOrder(context,order){
            try{
                const response=await AxiosInstance.delete(`admin/order/${order}/destroy`);
                context.commit('setorders',response.data);
            }catch(e){
                console.log("failed to delete order"+e);
            }
         }

    }
}
