<template>
    <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Users Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"></li>
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
            <div></div>
            <div>
                <div class="input-group">
                <input v-model="searchQuery" type="text" class="form-control" placeholder="Search...">
                  <div class="input-group-append">
                      <span class="input-group-text"><i class="fa fa-search text-primary" aria-hidden="true"></i></span>
                  </div>
                </div>
              </div>
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
                <tbody v-if="users.data.length > 0">
                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>
                       <router-link to="/admin/users/create">
                             <i class="fa fa-user-plus mr-2" ></i>

                        </router-link>

                      <router-link
                          v-if="user.email !== 'admin@gmail.com'" to="" @click.prevent="deleteUsers(user.id)">
                          <i class="fa fa-trash text-danger"></i>
                       </router-link>

                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                         <td colspan="9" class="text-danger text-center" >No Data found !...</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="float-right"><Bootstrap4Pagination :data="users" @pagination-change-page="getUsers" /></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref, watch } from 'vue';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';

const users = ref({'data': []});

const getUsers = (page = 1) => {
    axios.get(`/users?page=${page}`)
    .then((response) => {
        users.value = response.data; 
    })
    .catch((error) => {
        console.error('Error fetching items:', error);
    });
};

const searchQuery =ref(null);
const search = () => {
  axios.get('/users/search', {
    params: {
      query: searchQuery.value
    }
  })
  .then(response => {
    users.value = response.data;
  })
  .catch(error => {
    console.log(error);
  });
}; 

watch(searchQuery, () => {
  search();
})

const deleteUsers = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/users/${id}`)
            .then(() => {
                users.value.data = users.value.data.filter(user => user.id !== id);

                Swal.fire(
                    'Deleted!',
                    'Item has been deleted.',
                    'success'
                );   
                getUsers();
            })
            .catch((error) => {
                console.error('Error deleting event:', error);
            });
        }
    });
};


onMounted(() => {
    getUsers();
});


</script>
