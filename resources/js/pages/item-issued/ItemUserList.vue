<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Item Issued List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Issued Item</li>
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
                    <th scope="col">Item Name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Date Issued</th>
                    <th scope="col">Issued to</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody v-if="issues.data.length > 0">
                  <tr v-for="(issue, index) in issues.data" :key="issue.id">
                    <td>{{ index +1 }}</td>
                    <td>{{issue.item_name}}</td>
                    <td>{{issue.serial}}</td>
                    <td>{{issue.model}}</td>
                    <td>{{ issue.issued_date }}</td>
                    <td>{{ issue.issued_to }}</td>
                    <td>
                      <span class="badge badge-success">{{ issue.status }}
                      </span>
                    </td>
                    <td>
                         
                       <router-link :to="`/admin/items/${issue.id}/lists`">
                             	<i class=" 	fas fa-user-tie"></i>
                        </router-link>
                       <router-link :to="`/admin/items/${issue.id}/return`">
                        <i class="fa fa-undo text-danger ml-3"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                     <td colspan="8" class="text-danger text-center" >No Data found !...</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
            <Bootstrap4Pagination :data="issues" @pagination-change-page="getItems" />
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

const issues = ref({'data': []});

const getItems = (page = 1) => {
    axios.get(`/issue/items?page=${page}`)
    .then((response) => {
        issues.value = response.data; 
    })
    .catch((error) => {
        console.error('Error fetching items:', error);
    });
};

const searchQuery =ref(null);
const search = () => {
  axios.get('/issue/search', {
    params: {
      query: searchQuery.value
    }
  })
  .then(response => {
    issues.value = response.data;
  })
  .catch(error => {
    console.log(error);
  });
}; 

watch(searchQuery, () => {
  search();
})
onMounted (() => {
    getItems();
});
</script>
