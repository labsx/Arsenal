import './bootstrap';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router';
import { createPinia } from 'pinia'; 
import Routes from './routes.js';
import Login from './pages/auth/Login.vue';
import App from './App.vue';
import { useAuthUserStore } from './store/themeStore';

const app = createApp(App);
const pinia = createPinia();


const router = createRouter({
    routes: Routes,
    history: createWebHistory(),
});

router.beforeEach((to, from) => {
   const authUserStore = useAuthUserStore();
   if(authUserStore.user.name === '' && to.name !== 'admin.login'){
    authUserStore.getAuthUser();
   }
});

app.use(pinia);
app.use(router);
app.mount('#app');
