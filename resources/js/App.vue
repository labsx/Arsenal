<template>
     <div class="wrapper" id="app">

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
