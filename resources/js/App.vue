<template>
     <div class="wrapper" id="app">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item" id="toggleMenuIcon">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <div class="sidebar">
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img :src="user.avatar">
                        </div>
                    <div class="info">
                        <a href="#" class="d-block">{{user.name}}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <router-link to="/admin/dashboard" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </router-link>
                        </li>

                         <li class="nav-item">
                            <router-link
                                to="/admin/items/list"
                                active-class="active"
                                class="nav-link"
                                :class="$route.path.startsWith('/admin/items/list') ||
                                         $route.path.startsWith('/admin/items/create')  ? 'active' : ''">
                                <i class="nav-icon fas fa-list"></i>
                                <p>
                                    Items List
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/items/issue/list" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Issue Items
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/items/history" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    History
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/users" active-class="active" class="nav-link"
                            :class="
                                         $route.path.startsWith('/admin/users/create')  ? 'active' : ''">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    User List
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <router-link to="/admin/users/update" active-class="active" class="nav-link">
                                <i class="nav-icon fas fa-user-edit"></i>
                                <p>
                                    Profile
                                </p>
                            </router-link>
                        </li>

                        <li class="nav-item">
                            <form  class="nav-link">
                               
                                <a href="#" @click.prevent="logout" >
                                    <i class="nav-icon fas fa-sign-out-alt"></i>
                                    <p>
                                        Log out
                                    </p>
                                </a>
                            </form>
                        
                    
                        </li>
                    </ul>
                </nav>
             </div>
            </aside>

        <div class="content-wrapper">
            <router-view></router-view>
        </div>
    
        <footer class="main-footer text-center">
            <strong class="">Copyright &copy; sample  <a href="#">{{user.name}}</a>.</strong> All rights reserved.
        </footer>
    </div>
</template>
<script setup> 
import axios from 'axios';
import { onMounted, ref } from 'vue';

const user = ref({});
const fetchUser = () => {
    axios.get('/users/profile')
    .then((response) => {
        user.value = response.data;
    });
}

const logout = () => {
    axios.post('/logout')
    .then((response)=> {
        window.location.href = "/login";
    });
};
onMounted(()=> {
    fetchUser();
});
</script>
