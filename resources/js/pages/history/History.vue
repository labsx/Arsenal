<template>
  <ContentHeader title="History" />

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <div class="float-right ml-2">
                <button @click="printItems" class="btn btn-primary btn-sm">
                  <i class="fa fa-print mr-1"></i> Print
                </button>
              </div>
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
                    <th scope="col">Items name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Date issued</th>
                    <th scope="col">Date return</th>
                    <th scope="col">Issued to</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody v-if="histories.data.length > 0">
                  <tr v-for="item in histories.data" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial }}</td>
                    <td>{{ formatDate(item.date_issued) }}</td>
                    <td>{{ formatDate(item.return_date) }}</td>
                    <td>{{ item.issued_to }}</td>
                    <td>
                      <span :class="getStatusClass(item.status)">{{
                        item.status
                      }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="float-right">
            <Bootstrap4Pagination
              :data="histories"
              @pagination-change-page="getHistory"
            />
          </div>
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
import { useToastr } from "../../toastr";
import { debounce } from "lodash";
import { printHistory } from "../../store/print.js";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const printItems = () => {
  printHistory(histories.value.data, formatDate);
};

const histories = ref({ data: [] });
const getHistory = (page = 1) => {
  axios
    .get(`/history?page=${page}`)
    .then((response) => {
      histories.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/history", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      histories.value = response.data;
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

const getStatusClass = (status) => {
  if (status === "operating") {
    return "badge badge-success good-status";
  } else if (status === "decommissioned") {
    return "badge badge-danger bad-status";
  } else if (status === "under repair") {
    return "badge badge-warning bad-status";
  } else {
    return "badge badge-default";
  }
};

onMounted(() => {
  getHistory();
});
</script>

