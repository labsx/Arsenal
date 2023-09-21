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
                    <th scope="col">Item Name</th>
                    <th scope="col">Item Count</th>
                    <th scope="col">Date Issued</th>
                    <th scope="col">Issued to</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody  v-if="datas.data.length > 0">
                  <tr v-for="data in datas.data" :key="data">
                    <td>{{ data.name }}</td>
                    <td>{{ data.count }}</td>
                    <td>{{ formatDate(data.issued_date) }}</td>
                    <td>{{ data.issued_to }}</td>
                    <td>
                      <span class="badge badge-primary">{{ data.status }}
                      </span>
                    </td>
                    <!-- <td>
                       <router-link :to="`/admin/items/${issue.id}/return`">
                        <i class="fa fa-undo text-danger ml-3"></i>
                      </router-link> 
                    </td> -->

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
            <Bootstrap4Pagination :data="datas" @pagination-change-page="getItems" />
             <div class="btn-group float-right">
            <router-link
                to="/admin/items/issue/list"
                class="btn"
                :class="{ 'btn-secondary': isTable1Active, 'btn-default': !isTable1Active }"
                @click="activateTable(1)"
              >
                <span class="mr-1">Items 1</span>
                <span class="badge badge-pill badge-info"></span>
              </router-link>

              <router-link
                to="/admin/data/items/issue"
                class="btn"
                :class="{ 'btn-secondary': !isTable1Active, 'btn-default': isTable1Active }"
                @click="activateTable(2)"
              >
                <span class="mr-1">Items 2</span>
                <span class="badge badge-pill badge-primary"></span>
             </router-link>
        </div>
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
 import { formatDate } from '../../../helper.js';

 const datas = ref({'data': []});

const getItems = (page = 1) => {
    axios.get(`/data/issue/items?page=${page}`)
    .then((response) => {
        datas.value = response.data; 
    })
    .catch((error) => {
        console.error('Error fetching items:', error);
    });
};

const searchQuery =ref(null);
const search = () => {
  axios.get('/data/issue/search', {
    params: {
      query: searchQuery.value
    }
  })
  .then(response => {
    datas.value = response.data;
  })
  .catch(error => {
    console.log(error);
  });
}; 

const isTable1Active = ref(false); 

const activateTable = (tableNumber) => {
  if (tableNumber === 1) {
    isTable1Active.value = false;
  } else if (tableNumber === 2) {
    isTable1Active.value = true;
  }
};

watch(searchQuery, () => {
  search();
})
onMounted (() => {
    getItems();
});
</script>
