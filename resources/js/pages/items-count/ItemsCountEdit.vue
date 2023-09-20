<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                       <router-link to="/admin/list/count"><i class="fa fa-arrow-left mr-2 text-dark"></i></router-link> EDIT ITEMS
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/items/list">Items</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                            Edit
                           
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
                            <form @submit.prevent="editItemsCount()">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input v-model="form.name" type="text" class="form-control" id="title" placeholder="Enter item name" :class="{ 'is-invalid': errors.name }" >
                                            <span v-if="errors && errors.name" class="text-danger text-sm">{{ errors.name[0]}}</span>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input v-model="form.date" type="date" class="form-control flatpickr" :class="{ 'is-invalid': errors.date }" >
                                             <span v-if="errors && errors.date" class="text-danger text-sm">{{ errors.date[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Count</label>
                                            <input v-model="form.count" type="number" class="form-control" placeholder="Enter model" :class="{ 'is-invalid': errors.count }">
                                            <span v-if="errors && errors.count" class="text-danger text-sm">{{ errors.count[0]}}</span>
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
                                    <textarea v-model="form.description" class="form-control" id="description" rows="3" :class="{ 'is-invalid': errors.description }"
                                        placeholder="Enter Description"></textarea>
                                       <span v-if="errors && errors.description" class="text-danger text-sm">{{ errors.description[0]}}</span>
                                </div>
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-save mr-1"></i>Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
 import axios from 'axios';
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
  date: '',
  status: 'Good',
  description: '',
  status: '',
});

const DataItems = () => {
    axios.get(`/data/${route.params.id}/edit`)
    .then(({data}) => {
        form.name = data.name;
        form.date = data.date; 
        form.count = data.count;
        form.description = data.description;
        form.status = data.status
    })
};

const editItemsCount  = (values) => {
    axios.put(`/data/${route.params.id}/edit`, form)
    .then((response) => {
       router.push('/admin/list/count');    
       toastr.success('Items updated successfully !')  ;
    })
      .catch((error) => {
      if(error.response && error.response.status === 422){
         errors.value = error.response.data.errors;
      }
    });
};

onMounted(() => {
    DataItems();

   flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        defaultHour: 10,
    });
});
</script>


