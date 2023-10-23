<template>
  <ContentHeader title="Users Information" data="users" datas="list" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <div
                class="ml-2"
                v-if="authuserStore.user.email == 'admin@gmail.com'"
              >
                <button
                  class="btn btn-outline-primary btn-sm"
                  data-toggle="modal"
                  data-target="#createUsers"
                >
                  <i class="fa fa-plus-circle mr-1"></i>Add new user
                </button>
              </div>
            </div>
            <Search v-model="searchQuery" />
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">Avatar</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th
                      scope="col"
                      v-if="authuserStore.user.email == 'admin@gmail.com'"
                    >
                      Options
                    </th>
                  </tr>
                </thead>
                <tbody v-if="users.data.length > 0">
                  <tr v-for="user in users.data" :key="user.id">
                    <td>
                      <img
                        :src="user.avatar"
                        alt="Avatar"
                        style="width: 50px; height: 50px; border-radius: 50px"
                      />
                    </td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td v-if="authuserStore.user.email == 'admin@gmail.com'">
                      <router-link
                        v-if="user.email !== 'admin@gmail.com'"
                        to=""
                        @click.prevent="deleteUsers(user.id)"
                      >
                        <i class="fa fa-trash text-danger"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="9" class="text-danger text-center">
                      No Data found !...
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="float-right">
            <Bootstrap4Pagination
              :data="users"
              @pagination-change-page="getUsers"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <UserForm :getUsersFn="getUsers" />
</template>

<script setup>
import axios from "axios";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { userList } from "../../store/users/userslist.js";
import UserForm from "./UserForm.vue";
import Search from "../../pages/layout/Search.vue";

const { users, searchQuery, authuserStore, deleteUsers, getUsers } = userList();
</script>
