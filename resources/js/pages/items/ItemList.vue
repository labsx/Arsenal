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

                <button v-if="selectedItems.length > 0" @click="bulkDelete" class="btn btn-danger ml-2">
                  <i class="fa fa-trash ml-2"></i> Delete Selected
              </button>
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
                    <th> <input type="checkbox" v-model="selectAll" @change="toggleSelectAll" /></th>
                  
                    <th scope="col">Items</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Date Stored</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody v-if="items.data.length > 0">
                  <tr v-for="item in items.data" :key="item.id">
                           <td>
                            <input
          type="checkbox"
          @change="toggleSelection(item)"
          :checked="isSelected(item)"
        />
      </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial }}</td>
                    <td>{{ item.model }}</td>
                    <td>{{ formatDate(item.date) }}</td>
                    <td>
                      <span :class="getStatusClass(item.status)">{{ item.status }}</span>
                    </td>
                    <td >  
                      
                      <div class="text-align-center">
                          <router-link :to="`/admin/items/${item.id}/edit`" v-if="!shouldDisableLink(item.status)">
                          <i :class="statusIconClass(item.status)"></i>
                      </router-link>

                      <router-link :to="`/admin/items/${item.id}/issue`" v-if="!shouldDisableLink(item.status)">
                         <i :class="icon(item.status)" class="ml-2 text-secondary"></i>
                      </router-link>

                      <router-link to="" @click.prevent="deleteItems(item.id)">
                        <i class="fa fa-trash text-danger ml-2"></i>
                      </router-link>
                      </div>
                    
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="7" class="text-danger text-center" >No Data found !...</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
            <Bootstrap4Pagination :data="items" @pagination-change-page="getItems" />
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
import { computed } from 'vue';
import { useToastr } from '../../toastr';

const toastr = useToastr();

const items = ref({'data': []});

const icon = computed(() => (status) =>{
  if (status === 'Good') {
    return 'fa fa-user-plus';
  }else{
     return 'fa fa-user-plus';
  }
});

const statusIconClass = computed(() => (status) => {
  if (status === 'Good') {
    return 'fa fa-edit';
  } else if (status === 'issued') {
    return 'fa fa-exclamation-circle text-warning';
  } else if (status === 'Bad') {
    return 'fa fa-times-circle text-danger';
  } else {
    return 'fa fa-user-plus';
  }
});

const disabledStatuses = ['Bad', 'issued'];

const shouldDisableLink = (status) => {
  return disabledStatuses.includes(status);
};

const handleLinkClick = (status, event) => {
  if (isStatusBad(status) || isStatusIssued(status)) {
    event.preventDefault(); 
  }
};

const isStatusBad = (status) => {
  return status === 'Bad';
};

const isStatusIssued = (status) => {
  return status === 'issued';
};

const getItems = (page = 1) => {
    axios.get(`/items?page=${page}`)
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
                items.value.data = items.value.data.filter(item => item.id !== id);

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

const searchQuery =ref(null);
const search = () => {
  axios.get('/items/list/search', {
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

watch(searchQuery, () =>{
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

// const selectedItems = ref([]);
// const toggleSelection = (item) => {
//   const index = selectedItems.value.indexOf(item.id);
//   if (index === -1) {
//     selectedItems.value.push(item.id);
//   } else {
//     selectedItems.value.splice(index, 1);
//   }
// };

const bulkDelete = () => {
  axios
    .delete('/items', {
      data: {
        ids: selectedItems.value
      }
    })
    .then((response) => {
      items.value.data = items.value.data.filter(item => !selectedItems.value.includes(item.id));
      selectedItems.value.splice(0);

      toastr.success('Items deleted successfully');
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
    // Select all items
    selectedItems.value = items.value.data.map((item) => item.id);
  } else {
    // Deselect all items
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
    getItems();
});

</script>
