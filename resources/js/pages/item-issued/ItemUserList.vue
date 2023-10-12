<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Item Issued List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Issued Item</li>
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
            <div></div>
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
                    <th scope="col">Item Name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Date Issued</th>
                    <th scope="col">Issued to</th>
                    <th scope="col">Status</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody v-if="issues.data.length > 0">
                  <tr v-for="issue in issues.data" :key="issue.id">
                    <td>{{ issue.name }}</td>
                    <td>{{ issue.serial }}</td>
                    <td>{{ formatDate(issue.date_issued) }}</td>
                    <td>{{ issue.issued_to }}</td>
                    <td>
                      <span class="badge badge-primary"
                        >{{ issue.status }}
                      </span>
                    </td>
                    <td>
                      <router-link :to="`/admin/items/${issue.id}/lists`">
                        <i class="fas fa-user-tie"></i>
                      </router-link>

                      <router-link :to="`/admin/items/${issue.id}/return`">
                        <i class="fa fa-undo text-danger ml-3"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <!-- <td>No Data Found</td> -->
                    <td colspan="8" style="text-align: center;">
                        <img v-if="!issues.data.length" :src="imagePath" alt="No Data Found" style="max-width: 100%; height: 100%;" />
                  </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <Bootstrap4Pagination
            :data="issues"
            @pagination-change-page="getItems"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { ref, onMounted, watch } from "vue";
import Swal from "sweetalert2";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { formatDate } from "../../helper.js";
import { debounce } from "lodash";
import { deleteIssued } from "../../store/swal.js";
import imagePath from "/resources/image/images.jpeg";

const issues = ref({ data: [] });

const getItems = (page = 1) => {
  axios
    .get(`/issue?page=${page}`)
    .then((response) => {
      issues.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/issue", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      issues.value = response.data;
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
  getItems();
});
</script>
