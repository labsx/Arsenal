<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img :src="authUserStore.user.avatar" />
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ authUserStore.user.name }}</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item">
            <router-link
              to="/admin/dashboard"
              active-class="active"
              class="nav-link"
            >
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </router-link>
          </li>

          <li class="nav-item" :class="{ 'menu-open': isDropdownOpen }">
            <router-link
              to="/admin/items/list"
              class="nav-link"
              active-class="active"
              @click="toggleDropdown"
            >
              <i class="nav-icon fas fa-list"></i>

              <p>
                Items List
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
            <ul class="nav nav-treeview" v-if="isDropdownOpen">

                <li class="nav-item">
                <router-link
                  to="/admin/category/list"
                  class="nav-link"
                  active-class="active "
                >
                  <i class="fa fa-folder nav-icon"></i>
                  <p>Category List</p>
                </router-link>
              </li>


                <li class="nav-item">
                <router-link
                  to="/admin/field_groups/list"
                  class="nav-link"
                  active-class="active"
                >
                  <i class="fa fa-archive nav-icon"></i>
                  <p>Fields Group</p>
                </router-link>
              </li>

            </ul>
          </li>

            <li class="nav-item">
            <router-link
              to="/admin/employee"
              active-class="active"
              class="nav-link"
            >
              <i class="nav-icon fas fa-users"></i>
              <p>Employess List</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/admin/items/issue/list"
              active-class="active"
              class="nav-link"
              :class="
                $route.path.startsWith('/admin/items/issue/list') ||
                $route.path.startsWith('/admin/items/return')
                  ? 'active'
                  : ''
              "
            >
              <i class="nav-icon fas fa-users"></i>
              <p>Issue Items</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/admin/items/history"
              active-class="active"
              class="nav-link"
            >
              <i class="nav-icon fas fa-history"></i>
              <p>History</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/admin/users"
              active-class="active"
              class="nav-link"
              :class="
                $route.path.startsWith('/admin/users/create') ? 'active' : ''
              "
            >
              <i class="nav-icon fas fa-user"></i>
              <p>User List</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/admin/users/update"
              active-class="active"
              class="nav-link"
            >
              <i class="nav-icon fas fa-user-edit"></i>
              <p>Profile</p>
            </router-link>
          </li>

          <li class="nav-item">
            <form class="nav-link">
              <a href="#" @click.prevent="logout">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Log out</p>
              </a>
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";
import { useAuthUserStore } from "../store/themeStore.js";
import { ref } from "vue";

const authUserStore = useAuthUserStore();
defineProps({
  user: Object,
});

const router = useRouter();
const logout = () => {
  axios.post("/logout").then((response) => {
    router.push("/login");
    authUserStore.user.name = "";
  });
};

const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};
</script>
