<template>
  <div class="col-md-3 mb-4">
    <div class="card border-left-primary shadow h-80 py-3">
      <div class="d-flex justify-content-between mr-1">
        <h3></h3>
      </div>
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div
              class="text-xs font-weight-bold text-primary text-uppercase mb-1"
            >
              ITEMS
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ totalItemsCount || "No data available" }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-archive fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-60 py-3">
      <div class="d-flex justify-content-between mr-1">
        <h3 class="text-white"></h3>
      </div>
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div
              class="text-xs font-weight-bold text-success text-uppercase mb-1"
            >
              HISTORY
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              {{ totalHistoryCount || "No data available" }}
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-list-ol fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { displayCount } from "../../store/dashboardjs/dashboard.js";

const { totalItemsCount, totalHistoryCount } = displayCount();
</script>
