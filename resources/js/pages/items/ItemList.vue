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
              <router-link to="/admin/add/item">
                <button type="button" class="btn btn-primary btn-sm">
                  <i class="nav-icon fas fa-plus"></i>
                  Add item
                </button>
              </router-link>
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
                    <th scope="col">Item Name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Status</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Option</th>
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
                          style="height: 80px"
                        />
                      </div>
                    </td>

                    <td>
                      <router-link
                        v-if="item.status === 'operating'"
                        :to="`/admin/items/${item.id}/issue`"
                      >
                        <i class="fas fa-user-plus text-secondary mr-2"></i>
                      </router-link>

                      <router-link
                        v-if="
                          !['issued', 'decommissioned'].includes(item.status)
                        "
                        :to="`/admin/items/${item.id}/edit`"
                      >
                        <i class="fas fa-edit"></i>
                      </router-link>

                      <router-link to="" @click.prevent="deleteItems(item.id)">
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
              :data="items"
              @pagination-change-page="getItems"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch, nextTick } from "vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { debounce } from "lodash";
import { deleteItemsData } from "../../store/swal.js";
import Swal from "sweetalert2";
import JsBarcode from "jsbarcode";

const generateBarcode = (barcodeValue) => {
  const canvas = document.createElement("canvas");
  JsBarcode(canvas, barcodeValue, {
    format: "CODE128",
    displayValue: true,
  });
  return canvas.toDataURL();
};

//

const deleteItems = (id) => {
  deleteItemsData()
    .then((result) => {
      if (result.isConfirmed) {
        return axios.delete(`/items/${id}`);
      }
      throw new Error("Deletion not confirmed.");
    })
    .then(() => {
      items.value.data = items.value.data.filter((item) => item.id !== id);
      Swal.fire("Deleted!", "Item has been deleted.", "success");
      getItems();
    })
    .catch((error) => {
      console.error("Error deleting event:", error);
    });
};

const items = ref({ data: [] });

const getItems = (page = 1) => {
  axios
    .get(`/items?page=${page}`)
    .then((response) => {
      console.log("Response:", response.data);
      if (response.data) {
        items.value = response.data || [];
      }
    })
    .catch((error) => {
      console.error("Error fetching items and attributes:", error);
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
  getItems();
});
</script>
 
