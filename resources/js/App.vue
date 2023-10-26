<template>
  <div
    v-if="authUserStore.user.name !== ''"
    class="wrapper"
    :class="settingStore.theme === 'dark' ? 'dark-mode' : ''"
    id="app"
  >
    <AppNavBar />

    <SideBarLeft :user="user" />

    <div class="content-wrapper">
      <router-view></router-view>
    </div>

    <Footer :user="user" />
  </div>
  <div v-else>
    <router-view></router-view>
  </div>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import AppNavBar from "./components/AppNavBar.vue";
import SideBarLeft from "./components/SidebarLeft.vue";
import Footer from "./components/Footer.vue";
import { useAuthUserStore, useSettingStore } from "./store/themeStore.js";


const authUserStore = useAuthUserStore();
const settingStore = useSettingStore();
const user = ref({});

const fetchUser = () => {
  axios.get("/users/profile").then((response) => {
    user.value = response.data;
  });
};

onMounted(() => {
  fetchUser();
});
</script>
