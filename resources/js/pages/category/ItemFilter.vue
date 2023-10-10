<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Item List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Item List</li>
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
                    <th scope="col">Item Name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Status</th>
                    <th scope="col">Barcode</th>
                   
                  </tr>
                </thead>
                <tbody v-if="items.data.length > 0">
                  <tr v-for="item in items.data" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial }}</td>
                    <td>
                      <span :class="getStatusClass(item.status)">{{
                        item.status
                      }}</span>
                    </td>

                    <td>
                      <div class="barcode">
                        <img
                          :src="generateBarcode(item.barcode)"
                          alt="Barcode"
                          style="height: 50px"
                        />
                      </div>
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
              :data="items"
              @pagination-change-page="getFilterItem"
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
import { getCurrentInstance } from "vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { debounce } from "lodash";
import JsBarcode from "jsbarcode";

const generateBarcode = (barcodeValue) => {
  const canvas = document.createElement("canvas");
  JsBarcode(canvas, barcodeValue, {
    format: "CODE128",
    displayValue: true,
  });
  return canvas.toDataURL();
};

const route = getCurrentInstance().proxy.$route;
const items = ref({ data: [] });

const getFilterItem = (page = 1) => {
  const itemFilter = route.params.id;

  axios
    .get(`/items/${itemFilter}/filter-item?page=${page}`)
    .then((response) => {
      items.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/items", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      items.value = response.data;
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
  } else if (status === "issued") {
    return "badge badge-primary bad-status";
  } else {
    return "badge badge-default";
  }
};

onMounted(() => {
  getFilterItem();
});
</script>

