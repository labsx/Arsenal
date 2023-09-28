<template>
  <!-- Item Serial Status -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="d-flex justify-content-between mr-1">
        <h3></h3>
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
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div
              class="text-xs font-weight-bold text-primary text-uppercase mb-1"
            >
              Item (Serial)
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ totalItemsCount }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-list fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Items Name Serial Count -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="d-flex justify-content-between mr-1">
        <h3 class="text-white"></h3>
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
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div
              class="text-xs font-weight-bold text-success text-uppercase mb-1"
            >
              Item Serial (Count)
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{
                statusFilters === "All" ? selectedItemCount : selectedItemCount
              }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-info-circle fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- User Details -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2 custom-mt">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
              Users
            </div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                  {{ totalUsersCount }}
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-users fa-2x text-gray-300 custom-mt"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Notes -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2 custom-mt">
            <div
              class="text-xs font-weight-bold text-warning text-uppercase mb-1"
            >
              Notes
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ totalNotes }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-comments fa-2x text-gray-300 custom-mt"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const statusFilter = ref("TODAY");
const totalItemsCount = ref(0);
const statusFilters = ref();
const selectedItemCount = ref(0);
const uniqueItems = ref([]);
const totalUsersCount = ref(0);
const totalNotes = ref(0);

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
//
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
//
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
//
const fetchNote = () => {
  axios
    .get("/dashboard/notes")
    .then((response) => {
      totalNotes.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};


onMounted(() => {
  getItemsCount();
  fetchItems();
  getUsersCount();
  fetchNote();
});
</script>
<style scoped>
.hover:hover {
  background-color: white;
}
.custom-mt {
  margin-top: 2rem;
}
</style>
