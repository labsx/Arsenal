<template>
     <nav class="main-header navbar navbar-expand" :class="settingStore.theme === 'dark' ? 'navbar-dark': 'navbar-light'">
   <ul class="navbar-nav">
      <li class="nav-item" id="toggleMenuIcon">
         <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
         </a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
         <a @click.prevent="settingStore.changeTheme" href="#" class="nav-link">
            <i :class="settingStore.theme === 'dark' ? 'fa fa-moon' : 'fa fa-sun'"></i>
         </a>
      </li>
   </ul>
</nav>
</template>

<script setup>
import  { useSettingStore } from '../store/themeStore.js'

const settingStore = useSettingStore();

</script>
