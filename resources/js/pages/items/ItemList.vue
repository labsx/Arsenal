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
               <button class="btn btn-primary" data-toggle="modal" data-target="#createModal"> 
                  <i class="fa fa-plus-circle mr-1"></i> Add New Items
                </button>

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
                <thead >
                  <tr>
                    <th v-if="items.data.length > 0"> <input type="checkbox" v-model="selectAll" @change="toggleSelectAll" /></th>
                    <th scope="col">Items</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Date Stored</th>
                     <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody v-if="items.data.length > 0">
                  <tr v-for="item in items.data" :key="item.id">
                     <td>
                        <input type="checkbox" @change="toggleSelection(item)" :checked="isSelected(item)"/>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial }}</td>
                    <td>{{ item.model }}</td>
                    <td>{{ formatDate(item.date) }}</td>
                    <td>{{item.description}}</td>
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

<!-- modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="max-width: 70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADD ITEM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
           <div class="content" >
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="createItem()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input v-model="form.name"  type="text" class="form-control" id="title" placeholder="Enter item name">
                                              <span v-if="errors && errors.name" class="text-danger text-sm">{{ errors.name[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Serial #</label>
                                           <input v-model="form.serial" type="text" class="form-control" id="title" placeholder="Enter item serial number" >
                                             <span v-if="errors && errors.serial" class="text-danger text-sm">{{ errors.serial[0]}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input v-model="form.date" type="date" class="form-control flatpickr"  >
                                            <span v-if="errors && errors.date" class="text-danger text-sm">{{ errors.date[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Model</label>
                                            <input v-model="form.model" type="text" class="form-control" placeholder="Enter model" >
                                            <span v-if="errors && errors.model" class="text-danger text-sm">{{ errors.model[0]}}</span>
                                        </div>
                                        
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                           <input v-model="form.status" type="text" id="status" class="form-control" readonly="readonly">
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea v-model="form.description" class="form-control" id="description" rows="3" 
                                        placeholder="Enter Description"></textarea>
                                        <span v-if="errors && errors.description" class="text-danger text-sm">{{ errors.description[0]}}</span>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-2 text-danger"></i>Close</button>
        <button @click="createItem" type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Save Item</button>
      </div>
    </div>
  </div>
</div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch, reactive } from 'vue';
import Swal from 'sweetalert2';
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
import { formatDate } from '../../helper.js';
import { computed } from 'vue';
import { useToastr } from '../../toastr';
import flatpickr from "flatpickr";

const toastr = useToastr();
const errors = ref([]);
const items = ref({'data': []});

const form = reactive({
    name: '',
    serial: '',
    date: '',
    model: '',
    status: 'Good',
    description: '',
});



const createItem= () => {
  axios.post('/items', form)
    .then((response) => {
      toastr.success('Item created successfully!');
        $('#createModal').modal('hide'); 
        clearForm();
        getItems();
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else { (error.response && error.response.status === 422) 
        errors.value = error.response.data.errors;
      } 
    });
};

const clearForm = () => {
  form.name = '';
  form.serial = '';
  form.date = '';
  form.model = '';
  form.status = 'Good';
  form.description = '';
};

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

    getItems();

     flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        defaultHour: 10,
    });
});

</script>
