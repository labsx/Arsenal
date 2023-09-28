<template>
  <div class="col-md-3 mb-4">
    <div class="card border-left-primary shadow h-60 py-2">
      <div class="d-flex justify-content-between mr-1">
        <h3></h3>
        <select
          v-model="Filter"
          style="height: 2rem; outline: 2px solid transparent"
          class="px-1 rounded border-0 hover mt-2"
          @change="getStatusWithoutSerial"
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
              ITEM STATUS (Without Serial)
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ totalItemsCountWihtoutSerial }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-archive fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Item CountwihtoutSerial -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-60 py-2">
      <div class="d-flex justify-content-between mr-1">
        <h3 class="text-white"></h3>
        <select
          v-model="Filter"
          style="
            height: 2rem;
            outline: 2px solid transparent;
            max-height: 100px;
            overflow-y: auto;
          "
          class="px-1 rounded border-0 hover mt-2"
          @change="getCountWithoutSerial"
        >
          <option
            v-for="item in itemsWithoutSerialCount"
            :key="item.id"
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
              Item available (Without Serial)
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{
                itemsDisplayCount
                  ? ` ${itemsDisplayCount}`
                  : "No data available"
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
</template>
<script setup>
import axios from "axios";
import { onMounted, ref} from "vue";

const Filter = ref(0);
const Filters = ref(0);
const totalItemsCountWihtoutSerial = ref (0);
const itemsWithoutSerialCount = ref([]);

const AvailWithoutSerial = () => {
  axios
    .get("/dashboard/avail-without-serial")
    .then((response) => {
      itemsWithoutSerialCount.value = response.data.items;
    })
    .catch((error) => {
      console.error(error);
    });
};

const itemsDisplayCount = ref(null);
const getCountWithoutSerial = () => {
  axios
    .get("/dashboard/without-serial", {
      params: {
        status: Filter.value,
      },
    })
    .then((response) => {
      totalItemsCountWihtoutSerial.value = response.data.count;
      if (Filter.value !== "All") {
        const selectedItem = itemsWithoutSerialCount.value.find(item => item.name === Filter.value);
        if (selectedItem) {
          itemsDisplayCount.value = selectedItem.count;
        } else {
          itemsDisplayCount.value = null;  
        }
      }
    })
    .catch((error) => {
      console.error(error);
    });
};
const updateItemCount = () => {
    if (itemsDisplayCount.value) {
        const selectedName = selectedItem.value;
        itemsDisplayCount.value = itemsWithoutSerialCount.value.find(item => item.name === selectedName)?.count || 0;
    } else {
        itemsDisplayCount.value = 0;
    }
};

const getStatusWithoutSerial = () => {
  axios.get("/dashboard/without-serial", {
      params: {
        status: Filter.value,
      },
    })
    .then((response) => {
      totalItemsCountWihtoutSerial.value = response.data.count;
    })
    .catch((error) => {
      console.error(error);
    });
};



onMounted(() => {
 
  getStatusWithoutSerial();
  AvailWithoutSerial();

});
</script>
