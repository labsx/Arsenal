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
                class="btn btn-outline-primary ml-1 btn-sm"
                data-toggle="modal"
                data-target="#createFieldsGroup"
              >
                <i class="fa fa-plus-circle mr-1"></i>ADD FIELD GROUPS
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
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">Field Groups Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="field_groups.data.length > 0">
                  <tr v-for="field in field_groups.data" :key="field.id">
                    <td>{{ field.name }}</td>
                    <td>{{ field.description }}</td>

                    <td>
                      <router-link :to="`/admin/fields/${field.id}/add`">
                        <i class="fas fa-eye"></i>
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
              :data="field_groups"
              @pagination-change-page="getFieldsGroups"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <AddFieldGroups />
</template>
<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { deleteFieldGroups } from "../../store/swal.js";
import Swal from "sweetalert2";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { debounce } from "lodash";
import AddFieldGroups from "./AddFieldGroups.vue";

const field_groups = ref({ data: [] });

const getFieldsGroups = (page = 1) => {
  axios
    .get(`/field-group?page=${page}`)
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

const deleteFields = (id) => {
  deleteFieldGroups()
    .then((result) => {
      if (result.isConfirmed) {
        return axios.delete(`/field-group/${id}`);
      }
      throw new Error("Deletion not confirmed.");
    })
    .then(() => {
      field_groups.value.data = field_groups.value.data.filter(
        (field) => field.id !== id
      );
      Swal.fire("Deleted!", "Fields has been deleted.", "success");
      getFieldsGroups();
    })
    .catch((error) => {
      console.error("Error deleting Fields:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/field-group", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

watch(
  searchQuery,
  debounce(() => {
    search();
  }, 300)
);

onMounted(() => {
  getFieldsGroups();
});
</script>