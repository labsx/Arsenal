<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Item List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Item List</li>
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
            <div>
              <router-link to="/admin/items/create">
                <button class="btn btn-primary">
                  <i class="fa fa-plus-circle mr-1"></i> Add New Items
                </button>
              </router-link>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Items</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Date Stored</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in items" :key="item.id">
                    <td>{{ index +1 }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial }}</td>
                    <td>{{ item.model }}</td>
                    <td>{{ item.date }}</td>
                    <td>
                      <span class="badge badge-success">{{ item.status }}</span>
                    </td>
                    <td>
                       <router-link :to="`/admin/items/${item.id}/edit`">
                             <i class="fa fa-edit mr-2"></i>
                        </router-link>

                      <router-link to="" @click.prevent="deleteItems(item.id)">
                        <i class="fa fa-trash text-danger"></i>
                      </router-link>

                      <router-link :to="`/admin/items/${item.id}/issue`" class="ml-2">
                        <i class="fa fa-user-plus"></i>
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
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';

const items = ref([]);
const getItems = () => {
    axios.get('/items')
    .then((response) => {
        items.value = response.data; 
    })
    .catch((error) => {
        console.error('Error fetching items:', error);
    });
};

const deleteItems = (id) => {
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
            axios.delete(`/items/${id}`)
            .then(() => {
                items.value = items.value.filter(item => item.id !== id);

                Swal.fire(
                    'Deleted!',
                    'Item has been deleted.',
                    'success'
                );
               
                getItems();
            })
            .catch((error) => {
                console.error('Error deleting event:', error);
            });
        }
    });
};

onMounted (() => {
    getItems();
});
</script>