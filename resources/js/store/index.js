

import { createStore } from "vuex";

import auth from './auth/index';

import products from './products/index.js';

import payments from './payments/index.js';

// import orders from  './orders/index.js'


const store =createStore({
    state:{
    },
    mutations:{

    },
    getters:{

    },
    actions:{

    },
    modules:{
      auth,
      products,
      payments,
    //   orders,
    }
});


export default store;
