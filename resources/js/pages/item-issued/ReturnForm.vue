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
              <form @submit.prevent="returnItem()">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title">Item Name</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item name"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="client">Serial</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.serial"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item serial number"
                        disabled
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Model</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.model"
                        type="text"
                        class="form-control"
                        placeholder=""
                        readonly="readonly"
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Mfg. Date</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.mfg_date"
                        type="date"
                        class="form-control"
                        placeholder=""
                        readonly="readonly"
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Unit price</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.price"
                        type="integer"
                        class="form-control"
                        placeholder=""
                        readonly="readonly"
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Issue to</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.issued_to"
                        type="text"
                        class="form-control"
                        placeholder=""
                        readonly="readonly"
                      />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="date">Date Issued</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.date_issued"
                        type="date"
                        class="form-control flatpickr"
                        disabled
                      />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Date return</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.return_date"
                        type="date"
                        class="form-control flatpickr"
                        placeholder=""
                        :class="{ 'is-invalid': errors.return_date }"
                        style="background-color: white"
                      />
                      <span
                        v-if="errors && errors.return_date"
                        class="text-danger text-sm"
                        >{{ errors.return_date[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="client">Status</label>
                      <span class="text-danger"> *</span>
                      <select
                        v-model="form.status"
                        id="client"
                        class="form-control"
                        :class="{ 'is-invalid': errors.status }"
                      >
                        <option :value="form.serial ? 'operating' : 'issued'">
                          {{ form.serial ? "operating" : "issued" }}
                        </option>
                        <!-- <option value="operating">Operating</option> -->
                        <!-- <option value="issued">Issued</option> -->
                        <option value="decommissioned">decommissioned</option>
                        <option value="under repair">under repair</option>
                      </select>
                      <span
                        v-if="errors && errors.status"
                        class="text-danger text-sm"
                        >{{ errors.status[0] }}</span
                      >
                    </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-undo"></i> Return Item
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
import { reactive, onMounted, ref, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);
const form = reactive({
  name: "",
  serial: "",
  date_issued: "",
  status: "",
  issued_to: "",
  return_date: "",
  model: "",
  price: "",
  mfg_date: "",
});

const ItemReturn = () => {
  axios.get(`/items/${route.params.id}/return`).then(({ data }) => {
    form.name = data.name;
    form.serial = data.serial;
    form.status = data.status;
    form.date_issued = data.date_issued;
    form.issued_to = data.issued_to;
    form.model = data.model;
    form.price = data.price;
    form.mfg_date = data.mfg_date;
  });
};

const returnItem = () => {
  axios
    .post("/items/return", form)
    .then((response) => {
      toastr.success("Return item successfully!");
      router.push("/admin/items/history");
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
  ItemReturn();

  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "Y-m-d h:i K",
    defaultHour: 10,
  });
});
watch(form, (newValue) => {
  if (!newValue.serial) {
    form.status = "issued";
  }
});
</script>


