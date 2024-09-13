import './bootstrap';
import { createApp } from 'vue';

import App from './components/app.vue';
import router from './router/index'
import store from './store'


import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'


import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';





createApp(App).use(router).use(store).use(ElementPlus).mount("#app")
