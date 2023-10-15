<template>
<ContentHeader title="Item List" data="item" datas="list"/>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <router-link to="/admin/add/item">
                <button type="button" class="btn btn-outline-primary btn-sm">
                  <i class="nav-icon fas fa-plus"></i>
                  Add item
                </button>
              </router-link>

              <button
                @click="printItems"
                class="btn btn-outline-primary btn-sm ml-2"
              >
                <i class="fa fa-print mr-1"></i> Print
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
                <thead v-if="items.data.length > 0">
                  <tr>
                    <th scope="col">Item Name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Mfg. Date</th>
                    <th scope="col">Unit price</th>
                    <th scope="col">Status</th>
                    <!-- <th scope="col">Barcode</th> -->
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="items.data.length > 0">
                  <tr v-for="item in items.data" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial }}</td>
                    <td>{{ item.model }}</td>
                    <td>{{ formatDate(item.mfg_date) }}</td>
                    <td>₱ {{ item.price }}</td>
                    <td>
                      <span :class="getStatusClass(item.status)">{{
                        item.status
                      }}</span>
                    </td>

                    <td>
                      <router-link :to="`/admin/items/${item.id}/details`">
                        <i class="fas fa-eye text-primary mr-2"></i>
                      </router-link>

                      <!-- <router-link
                        v-if="item.status === 'operating'"
                        :to="`/admin/items/${item.id}/issue`"
                      >
                        <i class="fas fa-user-plus text-secondary mr-2"></i>
                      </router-link> -->

                      <router-link
                        v-if="
                          !['issued', 'decommissioned'].includes(item.status)
                        "
                        :to="`/admin/items/${item.id}/edit`"
                      >
                        <i class="fas fa-edit text-info"></i>
                      </router-link>

                      <router-link to="" @click.prevent="deleteItems(item.id)">
                        <i class="fa fa-trash text-danger ml-2"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="8" style="text-align: center">
                      <img
                        v-if="showImage && items.data.length === 0"
                        :src="imagePath"
                        alt="No Data Found"
                        style="max-width: 750px; height: auto"
                      />
                      <p style="font-weight: bold; color: red">
                        No data found !
                      </p>
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
import { printItemsData } from "../../store/print.js";
import { formatDate } from "../../helper.js";
import imagePath from "/resources/image/no data.gif";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const showImage = ref(false);
const printItems = () => {
  printItemsData(items.value.data, formatDate);
};

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

  setTimeout(() => {
    if (items.value.data.length === 0) {
      showImage.value = true;
    }
  }, 100);
});
</script>
 
