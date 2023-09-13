<template>
      <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                      MANAGE DATA
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/items/list">user</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                           items
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
                            <form @submit.prevent="UpdateUserItem()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input v-model="form.item_name" type="text" class="form-control" id="title" placeholder="Enter item name" readonly="readonly" >
                                              
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Serial #</label>
                                             <input v-model="form.serial"  type="text" class="form-control" id="title" placeholder="Enter item serial number" readonly="readonly" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label>Model</label>
                                            <input v-model="form.model" type="text" class="form-control" placeholder="Enter model" readonly="readonly">
                                           
                                        </div>
    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input v-model="form.status" type="text" class="form-control" placeholder="Enter model" readonly="readonly">
                                           
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">Date Issued</label>
                                            <input v-model="form.issued_date" type="date" class="form-control flatpickr" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Issued to</label>
                                            <input v-model="form.issued_to" type="text" class="form-control" placeholder="">
                                            <!-- <span v-if="errors && errors.issued_to" class="text-danger text-sm">{{ errors.issued_to[0]}}</span> -->
                                        </div>
                                    </div>
                                    
                                </div>

                                <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i> Update Data</button>
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
import 'flatpickr/dist/themes/light.css';

const router = useRouter();
const route = useRoute();
const toastr = useToastr(); 
const errors = ref([]);
const form = reactive({
  item_name: '',
  serial: '',
  issued_date: '',
  model: '',
  status: '',
  issued_to:'',
});

const ItemDetails = () => {
    axios.get(`/items/${route.params.id}/list`)
    .then(({data}) => {
        form.item_name = data.item_name;
        form.serial = data.serial; 
        form.model = data.model;
        form.status = data.status;
        form.issued_date = data.issued_date;
        form.issued_to = data.issued_to;
    })
};

const UpdateUserItem = (values) => {
    axios.put(`/items/${route.params.id}/lists`, form)
    .then((response) => {
    router.push('/admin/items/issue/list');    
    toastr.success('Items updated successfully !')  ;
    })
      .catch((error) => {
      if(error.response && error.response.status === 422){
         errors.value = error.response.data.errors;
      }
    });
};

onMounted(() => {
 ItemDetails();

   flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        defaultHour: 10,
    });
});
</script>


