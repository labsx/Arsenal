<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            :src="authUserStore.user.avatar"
            style="height: 40px; width: 40px; border-radius: 50%"
          />
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

          <li class="nav-item">
            <router-link
              to="/admin/items/list"
              active-class="active"
              class="nav-link"
            >
              <i class="nav-icon fas fa-list"></i>
              <p>Item List</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/admin/category/list"
              active-class="active"
              class="nav-link"
            >
              <i class="fa fa-folder nav-icon"></i>
              <p>Category List</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link
              to="/admin/field_groups/list"
              active-class="active"
              class="nav-link"
            >
              <i class="fa fa-archive nav-icon"></i>
              <p>Field Groups List</p>
            </router-link>
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
    <div
      class="d-flex align-items-end bd-highlight mb-3"
      style="height: 492px; position: absolute"
    >
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <input
            @change="handleFileChange"
            ref="fileInput"
            type="file"
            class="d-none"
          />
          <img
            @click="openFileInput"
            :src="imagePath"
            alt="No Data Found"
            style="
              height: 55px;
              width: 55px;
              border-radius: 50%;
            "
          />
        </div>
        <div class="info">
          <h5 class="d-block mt-3 text-white ml-2">Arsenal</h5>
        </div>
      </div>
    </div>
  </aside>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";
import { useAuthUserStore } from "../store/themeStore.js";
import { ref } from "vue";
import imagePath from "/resources/image/logo.png";

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
</script>
