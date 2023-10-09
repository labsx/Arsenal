<template>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="d-flex justify-content-between mr-1">
        <h3></h3>
      </div>
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div
              class="text-xs font-weight-bold text-primary text-uppercase mb-1"
            >
              Category
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ totalCategoryCount || "No data available" }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-list fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div
              class="text-xs font-weight-bold text-primary text-uppercase mb-1"
            >
              GROUP FIELDS
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ totalFiedlsCount || "No data available" }}
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

const totalCategoryCount = ref(0);
const totalFiedlsCount = ref(0);
const uniqueItems = ref([]);
const totalUsersCount = ref(0);
const totalNotes = ref(0);

const getCategoryCount = () => {
  axios
    .get("/dashboard/fields")
    .then((response) => {
      totalFiedlsCount.value = response.data.fields;
    })
    .catch((error) => {
      console.error(error);
    });
};
//
const getFieldsCount = () => {
  axios
    .get("/dashboard/category")
    .then((response) => {
      totalCategoryCount.value = response.data.categories;
    })
    .catch((error) => {
      console.error(error);
    });
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
  getCategoryCount();
  getFieldsCount();
  fetchItems();
  getUsersCount();
  fetchNote();
});
</script>
