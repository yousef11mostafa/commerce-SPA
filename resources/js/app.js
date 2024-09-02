import './bootstrap';
import { createApp } from 'vue';

import App from './components/app.vue';
import router from './router/index'
import store from './store'



import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

createApp(App).use(router).use(store).mount("#app")
