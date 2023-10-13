<template>
  <form>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Item</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/admin/dashboard">Home</router-link>
              </li>
              <li class="breadcrumb-item">Items</li>
              <li class="breadcrumb-item active">Edit</li>
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
                <form>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Item Name</label>
                        <input
                          v-model="form.name"
                          type="text"
                          class="form-control"
                          id="title"
                          placeholder="Enter Title"
                          :class="{ 'is-invalid': errors.name }"
                        />
                        <span
                          v-if="errors && errors.name"
                          class="text-danger text-sm"
                          >{{ errors.name[0] }}</span
                        >
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date">Serial</label>
                        <input
                          v-model="form.serial"
                          type="text"
                          class="form-control"
                          id="date"
                          :class="{ 'is-invalid': errors.serial }"
                        />
                        <span
                          v-if="errors && errors.serial"
                          class="text-danger text-sm"
                          >{{ errors.serial[0] }}</span
                        >
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date">Model</label>
                        <input
                          v-model="form.model"
                          type="text"
                          class="form-control"
                          id="date"
                          :class="{ 'is-invalid': errors.model }"
                        />
                        <span
                          v-if="errors && errors.model"
                          class="text-danger text-sm"
                          >{{ errors.model[0] }}</span
                        >
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date">Mfg. Date</label>
                        <input
                          v-model="form.mfg_date"
                          type="date"
                          class="form-control flatpickr"
                          id="date"
                          :class="{ 'is-invalid': errors.mfg_date }"
                          style="background: white"
                        />
                        <span
                          v-if="errors && errors.mfg_date"
                          class="text-danger text-sm"
                          >{{ errors.mfg_date[0] }}</span
                        >
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="date">Unit Price</label>
                        <input
                          v-model="form.price"
                          type="integer"
                          class="form-control"
                          id="date"
                          :class="{ 'is-invalid': errors.price }"
                        />
                        <span
                          v-if="errors && errors.price"
                          class="text-danger text-sm"
                          >{{ errors.price[0] }}</span
                        >
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="client">Choose</label>
                        <span class="text-danger"> *</span>
                        <select
                          id="fieldGroup"
                          class="form-control"
                          v-model="form.parent_id"
                          :class="{ 'is-invalid': errors.parent_id }"
                        >
                          <optgroup
                            v-for="subcategory in subcategories"
                            :key="subcategory.id"
                            :label="subcategory.name"
                          >
                            <option value="" disabled selected hidden>
                              Select Sub Category
                            </option>
                            <option
                              v-for="parentModel in subcategory.parent_models"
                              :key="parentModel.id"
                              :value="parentModel.id"
                            >
                              {{ parentModel.name }}
                            </option>
                          </optgroup>
                        </select>

                        <span
                          v-if="errors && errors.parent_id"
                          class="text-danger text-sm"
                          >{{ errors.parent_id[0] }}</span
                        >
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="client">Status</label>
                        <select
                          v-model="form.status"
                          id="client"
                          class="form-control"
                          :class="{ 'is-invalid': errors.status }"
                        >
                          <option value="" disabled selected hidden>
                            Select Status
                          </option>
                          <option value="operating">Operating</option>
                          <option value="decommissioned">Decommissioned</option>
                          <option value="under repair">Under Repair</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <h4>Attributes:</h4>

                  <div
                    v-for="(attribute, index) in form.value"
                    :key="index"
                    class="attribute"
                  >
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="title">Name</label>
                          <input
                            v-model="attribute.name"
                            :name="`value[${index}][label]`"
                            type="text"
                            class="form-control"
                            id="title"
                            placeholder=""
                            :class="{ 'is-invalid': attribute.name === '' }"
                          />
                        </div>
                      </div>

                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="date">Value</label>
                          <input
                            type="text"
                            class="form-control"
                            id="date"
                            v-model="attribute.value"
                            :name="`value[${index}][value]`"
                            :class="{ 'is-invalid': attribute.value === '' }"
                          />
                        </div>
                      </div>

                      <div class="col-md-1">
                        <div class="form-group">
                          <i
                            class="fa fa-times mt-4 text-danger"
                            @click="removeAttribute(index)"
                            style="cursor: pointer"
                          ></i>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="text-center">
                    <button
                      type="button"
                      class="btn btn-outline-info"
                      @click="addAttribute"
                    >
                      <i class="fa fa-plus"></i>
                      Add Attribute
                    </button>
                  </div>

                  <button
                    @click.prevent="handleSubmit()"
                    type="submit"
                    class="btn btn-outline-primary"
                  >
                    <i class="fa fa-save mr-2"></i>
                    Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>


<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";

const errors = ref({});
const toastr = useToastr();
const router = useRouter();
const route = useRoute();
const form = reactive({
  name: "",
  serial: "",
  model: "",
  price: "",
  mfg_date: "",
  status: "",
  parent_id: "",
  value: [{ name: "", value: "" }],
});

const addAttribute = () => {
  form.value.push({ name: "", value: "" });
};

const removeAttribute = (index) => {
  form.value.splice(index, 1);
};

//
const getItems = () => {
  axios
    .get(`/items/${route.params.id}/show`)
    .then((response) => {
      console.log("Response data:", response.data);

      if (response.data) {
        form.name = response.data.name;
        form.serial = response.data.serial;
        form.status = response.data.status;
        form.parent_id = response.data.parent_id;
        form.model = response.data.model;
        form.mfg_date = response.data.mfg_date;
        form.price = response.data.price;
      } else {
        console.error("Item data not found in the response.");
      }
    })
    .catch((error) => {
      console.error("Error fetching item details:", error);
    });
};

const getAttributes = () => {
  axios
    .get(`/items/${route.params.id}/attributes`)
    .then(({ data }) => {
      console.log("Attributes data:", data);

      if (Array.isArray(data)) {
        form.value = data.map((attribute) => ({
          name: attribute.name,
          value: attribute.value,
        }));
      } else {
        console.error("Invalid attributes data format.");
      }
    })
    .catch((error) => {
      console.error("Error fetching item attributes:", error);
    });
};

const handleSubmit = () => {
  console.log("Form submitted with data:", form.value);

  axios
    .put(`/items/${route.params.id}`, form)
    .then((response) => {
      toastr.success("Item updated successfully!");
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        if (error.response.data.errors && error.response.data.errors[0]) {
          toastr.error(error.response.data.errors[0]);
        } else {
          toastr.error("An error occurred while updating the item.");
        }
      }
    });
};

const parents = ref([]);
const getParent = () => {
  axios
    .get("/parent-data")
    .then((response) => {
      parents.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching field_group:", error);
    });
};

const subcategories = ref([]);
const getSubCategory = () => {
  axios
    .get("/parent/sub")
    .then((response) => {
      subcategories.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching sub-category", error);
    });
};

onMounted(() => {
  getSubCategory();
  getParent();
  getItems();
  getAttributes();

  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "Y-m-d h:i K",
    defaultHour: 10,
  });
});
</script>

