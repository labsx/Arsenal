<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">List of Item with serial</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <div class="d-flex justify-content-between">
                <h3>Item Status</h3>
                <select
                  v-model="statusFilter"
                  style="height: 2rem; outline: 2px solid transparent"
                  class="px-1 rounded border-0 hover"
                  @change="getItemsCount"
                >
                  <option value="TODAY" class="hover">All</option>
                  <option value="Good" class="hover">Good</option>
                  <option value="issued">Issued</option>
                  <option value="Bad">Bad</option>
                </select>
              </div>
              <h1 class="text-center">{{ totalItemsCount }}</h1>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <router-link to="/admin/items/list" class="small-box-footer">
              View Items List
              <i class="fas fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <div class="d-flex justify-content-between">
                <h3>Users</h3>
              </div>
              <h1 class="text-center">{{ totalUsersCount }}</h1>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <router-link to="/admin/users" class="small-box-footer">
              View User List
              <i class="fas fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <div class="d-flex justify-content-between">
                <h3 class="text-white">Items Count</h3>
                <select
                  v-model="statusFilters"
                  style="
                    height: 2rem;
                    max-height: 50px;
                    overflow-y: auto;
                    outline: 2px solid transparent;
                  "
                  class="px-1 rounded border-0 hover"
                  @change="getItemsCountByName"
                >
                  <option value="All" class="hover">All</option>
                  <option
                    v-for="item in uniqueItems"
                    :key="item.name"
                    :value="item.name"
                    class="hover"
                  >
                    {{ item.name }}
                  </option>
                </select>
              </div>
              <h1 class="text-center text-white">
                {{
                  statusFilters === "All"
                    ? selectedItemCount
                    : selectedItemCount
                }}
              </h1>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <router-link to="/admin/items/list" class="small-box-footer">
              View Items List
              <i class="fas fa-arrow-circle-right"></i>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";

const totalItemsCount = ref(0);
const statusFilter = ref("TODAY");
const statusFilters = ref();
const selectedItemCount = ref(0);

const uniqueItems = ref([]);

const fetchItems = () => {
  axios
    .get("/dashboard/items")
    .then((response) => {
      const itemsData = response.data.items;
      const uniqueItemNames = new Set(itemsData.map((item) => item.name));
      uniqueItems.value = Array.from(uniqueItemNames).map((name) => ({ name }));
    })
    .catch((error) => {
      console.error(error);
    });
};

const getItemsCountByName = () => {
  if (statusFilters.value === "All") {
    axios
      .get(`/dashboard/items/count-name`)
      .then((response) => {
        if (response.data && response.data.count) {
          selectedItemCount.value = response.data.count;
        }
      })
      .catch((error) => {
        console.error("Error fetching items data", error);
      });
  } else {
    axios
      .get(`/dashboard/items/count?name=${statusFilters.value}`)
      .then((response) => {
        if (response.data && response.data.count !== undefined) {
          selectedItemCount.value = response.data.count;
        } else {
          console.error(
            "Invalid or empty response for item count by name:",
            response
          );
        }
      })
      .catch((error) => {
        console.error("Error fetching item count by name:", error);
      });
  }
};

const getItemsCount = () => {
  axios
    .get("/dashboard", {
      params: {
        status: statusFilter.value,
      },
    })
    .then((response) => {
      totalItemsCount.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};

const totalUsersCount = ref(0);
const getUsersCount = () => {
  axios
    .get("/dashboard/users")
    .then((response) => {
      totalUsersCount.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};

onMounted(() => {
  getItemsCount();
  getUsersCount();
  fetchItems();
});
</script>
<style scoped>
.hover:hover {
  background-color: lightblue;
}
</style>


