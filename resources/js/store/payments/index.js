
import axios from 'axios';

export default{
    namespaced:true,

    state:{

       cart:[],
       orders:[],
    },
    getters:{
        cartsize(state){
            return state.cart.length;
        },
        getcart(state){
            return state.cart;
        },
        getorders(state){
            return state.orders;
        }

    },
    mutations:{


        addToCart(state, product) {
            let productInCartIndex = state.cart.findIndex(item => item.slug === product.slug );
            if(productInCartIndex != -1){
                state.cart[productInCartIndex].quantity++;
                return;
            }
            product.quantity = 1;
            state.cart.push(product);
        },

        removeFromCart(state,index){
            state.cart.splice(index, 1);
        },
        setOrder(state,data){
            state.orders.push(data);
         },
         clearcart(state){
             state.cart=[];
         }

    },
    actions:{
        clearCart(context){
            context.commit("clearcart");
        }

    }
}
