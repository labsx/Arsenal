<template>
     <div class="wrapper" :class="settingStore.theme === 'dark' ? 'dark-mode' : ''" id="app">

        <AppNavBar />

        <SideBarLeft :user="user"/>

        <div class="content-wrapper">
            <router-view></router-view>
        </div>

        <Footer :user="user" />
      
    </div>
</template>
<script setup> 
import axios from 'axios';
import { onMounted, ref } from 'vue';
import AppNavBar from './components/AppNavBar.vue';
import SideBarLeft from './components/SidebarLeft.vue';
import Footer from './components/Footer.vue';
import { useSettingStore } from './store/themeStore.js';
import { useAuthUserStore}  from './store/themeStore.js';

const authuserStore = useAuthUserStore();
authuserStore.getAuthUser();

const settingStore = useSettingStore();
const user = ref({});

const fetchUser = () => {
    axios.get('/users/profile')
    .then((response) => {
        user.value = response.data;
    });
}

onMounted(()=> {
    fetchUser();
});
</script>
