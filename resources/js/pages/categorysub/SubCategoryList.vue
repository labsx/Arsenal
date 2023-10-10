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
                    <th scope="col">Name</th>
                    <th scope="col">Date </th>
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="parents.data.length > 0">
                  <tr v-for="parent in parents.data" :key="parent.id">
                    <td>{{ parent.name }}</td>
                    <td>{{parent.created_at}}</td>
                   <td>
                      <router-link :to="`/admin/fields/${parent.id}/add`">
                        <i class="fas fa-eye"></i>
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
              :data="parents"
              @pagination-change-page="getParent"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { debounce } from "lodash";

const parents = ref({ data: [] });

const getParent = (page = 1) => {
    axios
    .get(`/parent?page=${page}`)
    .then((response) => {
      parents.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/parent", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      parents.value = response.data;
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
    getParent();
});
</script>
