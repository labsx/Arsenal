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
            <div>
                <div class="float-right ml-2">
                <button v-if="selectedItems.length > 0" @click="bulkDelete" class="btn btn-danger ml-2">
                    <i class="fa fa-trash"></i> Delete Selected
                </button>
            </div>
            </div>
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
                     <th v-if="items.data.length > 0"> <input type="checkbox" v-model="selectAll" @change="toggleSelectAll" /></th>
                    <th scope="col">Items name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Issued Item</th>
                    <th scope="col">Date issued</th>
                    <th scope="col">Date return</th>
                    <th scope="col">Issued to</th>
                    <th scope="col">Status</th>
                     <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="items.data.length > 0">
                  <tr v-for="item in items.data" :key="item.id">
                    <td>
                    <input type="checkbox" @change="toggleSelection(item)" :checked="isSelected(item)"/>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial}}</td>
                    <td>{{item.model}}</td>
                    <td>{{item.count}}</td>
                    <td>{{ formatDate(item.issued_date) }}</td>
                    <td>{{ formatDate(item.return_date) }}</td>
                    <td>{{item.issued_to}}</td>
                    <td>
                      <span :class="getStatusClass(item.status)">{{ item.status }}</span>
                    </td>
                    <td>
                       <router-link to="" @click.prevent="deleteItems(item.id)">
                            <i class="fa fa-trash text-danger ml-2"></i>
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
          <div class="float-right"><Bootstrap4Pagination :data="items" @pagination-change-page="getHistory" /></div>
          
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
import { formatDate } from '../../helper.js';
import { useToastr } from '../../toastr';

const toastr = useToastr();
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
            axios.delete(`/items/delete/${id}`)
            .then(() => {
                items.value.data = items.value.data.filter(item => item.id !== id);

                Swal.fire(
                    'Deleted!',
                    'History item has been deleted.',
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

const items = ref({'data': []});
const getHistory = (page = 1) => {
    axios.get(`/items/history?page=${page}`)
    .then((response) => {
        items.value = response.data; 
    })
    .catch((error) => {
        console.error('Error fetching items:', error);
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
    items.value = response.data;
  })
  .catch(error => {
    console.log(error);
  });
}; 

watch(searchQuery, () => {
  search();
})

const getStatusClass = (status) => {
    if (status === 'Good') {
        return 'badge badge-success good-status';
    } else if (status === 'issued') { 
        return 'badge badge-primary issued-status';
    } else if (status === 'Bad') { 
        return 'badge badge-danger bad-status';
    } else {
        return 'badge badge-default';
    }
};
//
const bulkDelete = () => {
  axios
    .delete('/history/delete-all', {
      data: {
        ids: selectedItems.value
      }
    })
    .then((response) => {
      items.value.data = items.value.data.filter(item => !selectedItems.value.includes(item.id));
      selectedItems.value.splice(0);
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'History deleted successfully'
        });
    })
    .catch((error) => {
      console.error('Error deleting items:', error);
    });
};

const isSelected = (item) => {
  return selectedItems.value.includes(item.id);
};

const selectedItems = ref([]);
const selectAll = ref(false);

const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedItems.value = items.value.data.map((item) => item.id);
  } else {
    selectedItems.value = [];
  }
};
const toggleSelection = (item) => {
  const index = selectedItems.value.indexOf(item.id);
  if (index === -1) {
    selectedItems.value.push(item.id);
  } else {
    selectedItems.value.splice(index, 1);
  }
};
onMounted (() => {
    getHistory();
});
</script>
<style scoped>
.good-status {
    background-color: green;
    color: white;
}

.issued-status {
    background-color: blue;
    color: white;
}
</style>
