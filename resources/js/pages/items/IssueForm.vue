<template>
      <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                      ISSUE ITEM 
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">Home</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link to="/admin/items/list">Users</router-link>
                        </li>
                        <li class="breadcrumb-item active">
                           Add
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
                                               <span v-if="errors && errors.serial" class="text-danger text-sm">{{ errors.serial[0]}}</span>
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

                                <button type="submit" class="btn btn-primary">Submit</button>
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
  status: 'issued',
  issued_to:'',
});

const getItemsData = () => {
    axios.get(`/items/${route.params.id}/issue`)
    .then(({data}) => {
        form.item_name = data.name;
        form.serial = data.serial; 
        form.model = data.model;
    })
};

const createIssueItem = () => {
  axios.post('/issue/items', form)
    .then((response) => {
      toastr.success('Successfully issued item!');
      router.push('/admin/items/issue/list'); 
    })
    .catch((error) => {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
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


