

import { createStore } from "vuex";

import products from './products/index.js';

import payments from './payments/index.js';


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
      products,
      payments
    }
});


export default store;
