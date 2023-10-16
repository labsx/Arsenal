<template>
 <ContentHeader title="" data="category" datas="edit item list" />
  <!-- <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Sub Category</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Sub category</li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </div> -->

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update category item list</h3>
            </div>

            <form>
              <div class="card-body">
                <div class="form-group">
                  <label for="appName">Category Sub Name</label>
                  <span class="text-danger"> *</span>
                  <input
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder=""
                    :class="{ 'is-invalid': errors.name }"
                  />
                  <span
                    v-if="errors && errors.name"
                    class="text-danger text-sm"
                    >{{ errors.name[0] }}</span
                  >
                </div>
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="saveParent"
                  type="submit"
                  class="btn btn-primary"
                >
                  <i class="fa fa-save mr-1"></i>Save Changes
                </button>
              </div>
            </form>
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
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);

const form = reactive({
  name: "",
});

const groupDetails = () => {
  axios
    .get(`/parent/${route.params.id}`)
    .then(({ data }) => {
      console.log("Field Group data:", data);
      form.name = data.name;
    })
    .catch((error) => {
      console.error("Error fetching field group details:", error);
    });
};

const saveParent = () => {
  axios
    .put(`/parent/${route.params.id}`, {
      name: form.name,
    })
    .then(() => {
      toastr.success("category item list updated successfully!");
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        errors.value = [];
      }
    });
};

onMounted(() => {
  groupDetails();
});
</script>