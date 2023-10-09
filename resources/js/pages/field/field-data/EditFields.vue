<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit fields data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
              <router-link to="/admin/dashboard">Home</router-link>
            </li>
            <li class="breadcrumb-item">
              <router-link to="/admin/appointments">Fields groups</router-link>
            </li>
            <li class="breadcrumb-item active">Fields</li>
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
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="title">Label</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.label"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter label"
                        :class="{ 'is-invalid': errors.label }"
                      />
                      <span
                        v-if="errors && errors.label"
                        class="text-danger text-sm"
                        >{{ errors.label[0] }}</span
                      >
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea
                    v-model="form.description"
                    class="form-control"
                    id="description"
                    rows="3"
                    placeholder="Enter Description"
                  ></textarea>
                </div>
                <div class="form-group">
                  <input
                    v-model="form.is_required"
                    type="checkbox"
                    style="width: 15px; height: 15px"
                    :checked="form.is_required === 'required'"
                  />
                  <label class="ml-2">required</label>
                </div>

                <router-link to="/admin/field_groups/list">
                  <button type="submit" class="btn btn-primary mr-2">
                    Back
                  </button>
                </router-link>
                <button
                  @click.prevent="saveField"
                  type="submit"
                  class="btn btn-primary"
                >
                  Submit
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
import { useToastr } from "../../../toastr";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);

const form = reactive({
  name: "",
  is_required: "",
  description: "",
});

const fieldsData = () => {
  axios
    .get(`/fields/${route.params.id}`)
    .then(({ data }) => {
      console.log("Fields data:", data);
      form.label = data.label;
      form.is_required = data.is_required;
      form.description = data.description;
    })
    .catch((error) => {
      console.error("Error fetching category details:", error);
    });
};

const saveField = () => {
  form.is_required = form.is_required ? "required" : "not required";
  axios
    .put(`/fields/${route.params.id}`, form)
    .then(() => {
      toastr.success("fields updated successfully!");
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        toastr.error(message);
        // getItemsFn();
        errors.value = [];
      }
    });
};

onMounted(() => {
  fieldsData();
});
</script>