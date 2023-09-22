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
                            <form @submit.prevent="returnItem()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Item Name</label>
                                            <input v-model="form.name" type="text" class="form-control" id="title" placeholder="Enter item name" disabled >
                                              
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="client">Serial #</label>
                                             <input v-model="form.serial"  type="text" class="form-control" id="title" placeholder="Enter item serial number" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label>Model</label>
                                            <input v-model="form.model" type="text" class="form-control" placeholder="Enter model" disabled>
                                           
                                        </div>
    
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Issue to</label>
                                            <input v-model="form.issued_to" type="text" class="form-control" placeholder="" readonly="readonly">
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Item Count (Optional)</label>
                                            <input v-model="form.count" type="text" class="form-control" :disabled="form.count == 0" />
                                            <span v-if="errors && errors.count" class="text-danger text-sm">{{ errors.count[0]}}</span> 
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date">Date Issued</label>
                                            <input v-model="form.issued_date" type="date" class="form-control flatpickr" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date return</label>
                                            <input v-model="form.return_date" type="date" class="form-control flatpickr" placeholder="">
                                            <span v-if="errors && errors.return_date" class="text-danger text-sm">{{ errors.return_date[0]}}</span>
                                        </div>
                                    </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                             <label for="client">Status</label>
                                                <select v-model="form.status"  class="form-control">
                                                    <option value="Good">Good</option>
                                                    <option value="Bad">Bad</option>
                                                </select>
                                                <span v-if="errors && errors.status" class="text-danger text-sm">{{ errors.status[0]}}</span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <button type="submit" class="btn btn-primary"><i class="fa fa-undo"></i>  Return Item</button>
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
  name: '',
  serial: '',
  issued_date: '',
  model: '',
  status: '',
  issued_to:'',
  return_date: '',
  count: 0,
});

const ItemReturn = () => {
    axios.get(`/items/${route.params.id}/return`)
    .then(({data}) => {
        form.name = data.name;
        form.serial = data.serial; 
        form.model = data.model;
        form.status = data.status;
        form.issued_date = data.issued_date;
        form.issued_to = data.issued_to;
        form.count = data.count;
    })
};

const returnItem= () => {
  axios.post('/items/return', form)
    .then((response) => {
      toastr.success('Return item successfully!');
      router.push('/admin/items/history'); 
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
 ItemReturn();

   flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        defaultHour: 10,
    });
});
</script>


