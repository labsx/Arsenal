<template>
      <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                       <router-link to="/admin/list/count"><i class="fa fa-arrow-left mr-2 text-primary"></i></router-link>ISSUE ITEM 
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/items/list">Issue</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                           Item
                            </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="createIssueItem()">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input v-model="form.name" type="text" class="form-control" id="title" placeholder="Enter item name" disabled>
                                              
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label>Count</label>
                                            <input v-model="form.count" type="number" class="form-control" placeholder="Enter model" >
                                           
                                        </div>
    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input v-model="form.status" type="text" class="form-control" placeholder="Enter model" disabled>
                                           
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date Issued</label>
                                            <input v-model="form.issued_date" type="date" class="form-control flatpickr" >
                                            <span v-if="errors && errors.issued_date" class="text-danger text-sm">{{ errors.issued_date[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Issued to</label>
                                            <input v-model="form.issued_to" type="text" class="form-control" placeholder="">
                                            <span v-if="errors && errors.issued_to" class="text-danger text-sm">{{ errors.issued_to[0]}}</span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <button type="submit" class="btn btn-primary"> <i class="fa fa-save mr-1"></i>Issue item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
 import { reactive, onMounted, ref } from 'vue';
 import { useRouter, useRoute } from 'vue-router';
 import { useToastr } from '../../toastr';
 import flatpickr from "flatpickr";


const router = useRouter();
 const route = useRoute();
 const toastr = useToastr(); 
 const errors = ref([]);
const form = reactive({
  name: '',
  count: '',
  issued_date: '',
  status: 'issued',
  issued_to:'',
});

const getItemsData = () => {
    axios.get(`/data/${route.params.id}/issue`)
    .then(({data}) => {
        form.name = data.name;
        form.count = data.count; 
    })
};

const createIssueItem = () => {
  axios.post('/issue_data', form)
    .then((response) => {
      toastr.success('Successfully issued item!');
      router.push('/admin/data/list'); 
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      } else {
        toastr.error('An unexpected error occurred. Please try again.');
      }
    });
};

onMounted(() => {
   getItemsData();

   flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        defaultHour: 10,
    });
});
</script>


