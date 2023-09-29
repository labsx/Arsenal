<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="container-fluid">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 mt-3">Dashboard</h1>
          </div>

          <div class="row">
            <DashboardItemDetails />
          </div>
          <div class="row">
            <DashboardWithoutSerial />
            <DashbBoardNotes />
          </div>
          <div class="row">
            <DashbBoardProgressBar />
            <DashboardUsers/>
          </div>
        </div>
      </div>
      <div></div>
    </div>
  </div>
</template>

<script setup>
import { timeDate } from "./../helper.js";
import DashbBoardNotes from "../components/dashboard-sub/DashboardNotes.vue";
import DashbBoardProgressBar from "../components/dashboard-sub/DashboardProgressBar.vue";
import DashboardItemDetails from "../components/dashboard-sub/DashboardItemDetails.vue";
import DashboardWithoutSerial from "../components/dashboard-sub/DashboardWithoutSerial.vue";
import DashboardUsers from "../components/dashboard-sub/DashboardUsers.vue";
</script>


