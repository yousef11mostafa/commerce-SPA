
import axios from 'axios';

export default{
    namespaced:true,

    state:{
       products:[],
       product:{},
       cart:[],
       orders:[],
    },
    getters:{
        cartsize(state){
            return state.cart.length;
        },
        getproducts(state){
            return state.products;
        },
        getproduct(state){
            return state.product;
        }
    },
    mutations:{
           setproducts(state,products){
              state.products=products;
           },
           setproduct(state,product){
              state.product=product;
           },
  
    },
    actions:{
        async getproducts({commit}){
             let response =await axios.get("http://127.0.0.1:8000/api/v1/products");
            //  console.log(response.data)
             commit("setproducts",response.data)
        },
        async getproduct({commit},slug){
             let response =await axios.get("http://127.0.0.1:8000/api/v1/products/" + slug);
             console.log(response.data)
             commit("setproduct",response.data)
        }
    }
}