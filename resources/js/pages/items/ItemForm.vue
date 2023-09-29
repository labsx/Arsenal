<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        Edit Items
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
                            <form @submit.prevent="editItem()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input v-model="form.name" type="text" class="form-control" id="title" placeholder="Enter item name" :class="{ 'is-invalid': errors.name }">
                                              <span v-if="errors && errors.name" class="text-danger text-sm">{{ errors.name[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Serial (Optional)</label>
                                            <input v-model="form.serial" type="text" class="form-control" id="title" placeholder="Enter item serial number" :class="{ 'is-invalid': errors.serial}" >
   
                                             <span v-if="errors && errors.serial" class="text-danger text-sm">{{ errors.serial[0]}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input v-model="form.date" type="date" class="form-control flatpickr"  :class="{ 'is-invalid': errors.date }" style="background-color: white;">
                                            <span v-if="errors && errors.date" class="text-danger text-sm">{{ errors.date[0]}}</span>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date">Count (Optional)</label>
                                            <input v-model="form.count" type="number" class="form-control"  :class="{ 'is-invalid': errors.date }">
                                            <span v-if="errors && errors.count" class="text-danger text-sm">{{ errors.count[0]}}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Model (Optional)</label>
                                            <input v-model="form.model" type="text" class="form-control" placeholder="Enter model" :class="{ 'is-invalid': errors.model }"  :disabled="form.count > 1">
                                            <span v-if="errors && errors.model" class="text-danger text-sm">{{ errors.model[0]}}</span>
                                        </div>
                                        
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                             <select v-model="form.status"  class="form-control" :class="{ 'is-invalid': errors.status }">
                                                     <option value="Good">Good</option>
                                                     <option value="Broken" v-if="form.serial">Broken</option>
                                                      <option value="Under Repair" v-if="form.serial">Under Repair</option>
                                                </select>
                                           <!-- <input v-model="form.status" type="text" id="status" class="form-control" > -->
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
import { reactive, ref, onMounted } from 'vue';
import { useToastr } from '../../toastr';
import { useRouter, useRoute } from 'vue-router';
import flatpickr from "flatpickr";
import 'flatpickr/dist/themes/light.css';

const toastr = useToastr();
const errors = ref([]);
const router = useRouter();
const route = useRoute();

const form = reactive({
    name: '',
    serial: '',
    date: '',
    model: '',
    status: 'Good',
    description: '',
    count: '',
});

const getItems = () => {
    axios.get(`/items/${route.params.id}/edit`)
    .then(({data}) => {
        form.name = data.name;
        form.serial = data.serial;
        form.date = data.date;
        form.model = data.model;
        form.status = data.status;
        form.description = data.description;
         form.count = data.count;
    })
};

const editItem  = (values) => {
    axios.put(`/items/${route.params.id}/edit`, form)
    .then((response) => {
       router.push('/admin/items/list');    
       toastr.success('Items updated successfully !')  ;
    })
      .catch((error) => {
      if(error.response && error.response.status === 422){
         errors.value = error.response.data.errors;
      }
    });
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
