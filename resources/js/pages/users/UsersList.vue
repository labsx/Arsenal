<template>
    <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">USERS DATA</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">users information</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr> 
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="user in users" :key="user.id">
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                  
                   
                    <td>
                       <router-link to="">
                             <i class="fa fa-edit mr-2"></i>
                        </router-link>

                      <router-link to="" >
                        <i class="fa fa-trash text-danger"></i>
                      </router-link> 

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from 'vue';

const users = ref([]);

const getUsers = () => {
    axios.get('/users')
    .then((response) => {
        users.value = response.data; 
    })
    .catch((error) => {
        console.error('Error fetching items:', error);
    });
};
onMounted(() => {
    getUsers();
});


</script>
