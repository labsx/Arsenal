<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Fields Groups</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Fields Group List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <button
                class="btn btn-primary ml-1 btn-sm"
                data-toggle="modal"
                data-target="#createFieldData"
              >
                <i class="fa fa-plus-circle mr-1"></i>ADD FIELDS
              </button>
            </div>
            <div>
              <div class="input-group">
                <input
                  v-model="searchQuery"
                  type="text"
                  class="form-control"
                  placeholder="Search..."
                />
                <div class="input-group-append">
                  <span class="input-group-text"
                    ><i class="fa fa-search text-primary" aria-hidden="true"></i
                  ></span>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Label</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody v-if="fields.data.length > 0">
                  <tr v-for="field in fields.data" :key="field.id">
                    <td>{{ field.label }}</td>
                    <td>{{ field.description }}</td>
                    <td>{{ field.is_required }}</td>
                    <td>

                      <router-link :to="`/admin/edit/${field.id}/fields`">
                        <i class="fas fa-edit"></i>
                      </router-link>

                      <router-link
                        to=""
                        @click.prevent="deleteFields(field.id)"
                      >
                        <i class="fa fa-trash text-danger ml-2"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="7" class="text-danger text-center">
                      No Data found !...
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div>
            <Bootstrap4Pagination
              :data="fields"
              @pagination-change-page="getFieldsById"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <AddFieldsData />
</template>
<script setup>
import axios from "axios";
import { onMounted, ref, watch, getCurrentInstance } from "vue";
import Swal from "sweetalert2";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { debounce } from "lodash";
import { useToastr } from "../../../toastr";
import AddFieldsData from "./AddFieldsData.vue";
import { deleteFieldGroups } from "../../../store/swal.js";

const toastr = useToastr();

const route = getCurrentInstance().proxy.$route;
const fields = ref({ data: [] });
//display fields by id
const getFieldsById = (page = 1) => {
  const fieldId = route.params.id;

  axios
    .get(`/fields/${fieldId}/show?page=${page}`)
    .then((response) => {
      fields.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

const deleteFields = (id) => {
  deleteFieldGroups()
    .then((result) => {
      if (result.isConfirmed) {
        return axios.delete(`/fields/${id}`);
      }
      throw new Error("Deletion not confirmed.");
    })
    .then(() => {
      fields.value.data = fields.value.data.filter((field) => field.id !== id);
      Swal.fire("Deleted!", "Fields has been deleted.", "success");
      getFieldsById();
    })
    .catch((error) => {
      console.error("Error deleting Fields:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/fields/search", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      fields.value = response.data;
    })
    .catch((error) => {
        console.error("Error in search:", error);
    });
};

watch(
  searchQuery,
  debounce(() => {
    search();
  }, 300)
);

onMounted(() => {
  getFieldsById();
});
</script>