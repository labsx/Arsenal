<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">History</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">History</li>
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
                <input v-model="searchQuery" type="text" class="form-control" placeholder="Search...">
              </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Items name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Date issued</th>
                     <th scope="col">Date return</th>
                    <th scope="col">Status</th>
                    <th scope="col">Issued to</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody v-if="history.data.length > 0">
                  <tr v-for="(data, index) in history.data" :key="data.id">
                     <td>{{ index +1 }}</td>
                    <td>{{ data.item_name }}</td>
                    <td>{{ data.serial}}</td>
                    <td>{{data.model}}</td>
                    <td>{{data.issued_date}}</td>
                    <td>{{data.return_date}}</td>
                    <td>
                      <span class="badge badge-success">{{data.status}}</span>
                    </td>
                    <td>{{data.issued_to}}</td>
                    <td>
                       <router-link to="" @click.prevent="delHistory(data.id)">
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
          <div class="float-right"><Bootstrap4Pagination :data="history" @pagination-change-page="getHistory" /></div>
          
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch } from 'vue';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';


const history = ref({'data': []});
const getHistory = (page = 1) => {
    axios.get(`/items/history?page=${page}`)
    .then((response) => {
        history.value = response.data; 
    })
    .catch((error) => {
        console.error('Error fetching items:', error);
    });
};

const delHistory = (id) => {
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
            axios.delete(`/return/${id}`)
            .then(() => {
                history.value.data = history.value.data.filter(data => data.id !== id);

                Swal.fire(
                    'Deleted!',
                    'Item has been deleted.',
                    'success'
                );
               
                getHistory();
            })
            .catch((error) => {
                console.error('Error deleting event:', error);
            });
        }
    });
};

const searchQuery =ref(null);
const search = () => {
  axios.get('/items/search', {
    params: {
      query: searchQuery.value
    }
  })
  .then(response => {
    history.value = response.data;
  })
  .catch(error => {
    console.log(error);
  });
}; 

watch(searchQuery, () => {
  search();
})


onMounted (() => {
    getHistory();
});
</script>
