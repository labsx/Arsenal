<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Manage Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/admin/dashboard">Home</router-link>
            </li>
            <li class="breadcrumb-item">
              <router-link to="/admin/items/list">user</router-link>
            </li>
            <li class="breadcrumb-item active">items</li>
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
                      <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item name"
                        readonly="readonly"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="client">Serial</label>
                      <input
                        v-model="form.serial"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item serial number"
                        readonly="readonly"
                      />
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="client">Model</label>
                      <input
                        v-model="form.model"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item serial number"
                        readonly="readonly"
                      />
                    </div>
                  </div>

                   
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Mfg. Date</label>
                      <input
                        v-model="form.mfg_date"
                        type="date"
                        class="form-control"
                        id="title"
                        placeholder=""
                        readonly="readonly"
                      />
                    </div>
                  </div>
                

                 <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Unit price</label>
                      <input
                        v-model="form.price"
                        type="integer"
                        class="form-control"
                        id="title"
                        placeholder="Enter item serial number"
                        readonly="readonly"
                      />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="date">Date Issued</label>
                      <input
                        v-model="form.date_issued"
                        type="date"
                        class="form-control flatpickr"
                        style="background: white"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Issued to</label>
                      <input
                        v-model="form.issued_to"
                        type="text"
                        class="form-control"
                        placeholder=""
                      />
                      <span
                        v-if="errors && errors.issued_to"
                        class="text-danger text-sm"
                        >{{ errors.issued_to[0] }}</span
                      >
                    </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-save mr-1"></i> Update Data
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { reactive, onMounted, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);
const form = reactive({
  item_name: "",
  serial: "",
  date_issued: "",
  model: "",
  status: "",
  issued_to: "",
  mfg_date: "",
  price: "",
});

const ItemDetails = () => {
  axios.get(`/issues/${route.params.id}`).then(({ data }) => {
    form.name = data.name;
    form.serial = data.serial;
    form.date_issued = data.date_issued;
    form.issued_to = data.issued_to;
    form.model = data.model;
    form.mfg_date = data.mfg_date;
    form.price = data.price;
  });
};

const UpdateUserItem = (values) => {
  axios
    .put(`/issues/${route.params.id}`, form)
    .then((response) => {
      router.push("/admin/items/issue/list");
      toastr.success("Items successfully issued!");
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      } else {
        toastr.error("An unexpected error occurred. Please try again.");
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


