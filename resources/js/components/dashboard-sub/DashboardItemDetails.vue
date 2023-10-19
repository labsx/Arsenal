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
import { displayCount } from "../../store/dashboardjs/dashboard.js";

const { totalCategoryCount, totalUsersCount,totalFiedlsCount, totalNotes  } = displayCount();
</script>
