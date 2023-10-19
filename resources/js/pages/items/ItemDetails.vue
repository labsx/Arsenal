<template>
  <header>
    <h1>{{ form.name }} ( {{ form.status }})</h1>
    <div class="mr-5 mt-5">
      <router-link
        v-if="status !== 'under repair' && status !== 'decommissioned'"
        :to="
          status === 'operating'
            ? `/admin/items/${form.id}/issue`
            : `/admin/items/${historyId}/return`
        "
        class="btn btn-info btn-sm"
      >
        <i class="fas fa-edit"></i>
        {{ status === "operating" ? "Issue" : "Return" }}
      </router-link>
    </div>
  </header>
  <div class="container">
    <div class="main">
      <h2>Item Details</h2>
      <p class="no-margin">Model: {{ form.serial }}</p>
      <p class="no-margin">Model: {{ form.model }}</p>
      <p class="no-margin">Price: ₱ {{ form.price ? form.price : "none" }}</p>
      <p class="no-margin">
        Mfg. Date: {{ form.mfg_date ? form.mfg_date : "none" }}
      </p>
      <p class="no-margin">
        Manufacturer: {{ form.manufacturer ? form.manufacturer : "none" }}
      </p>
      <p class="no-margin">
        Location: {{ form.location ? form.location : "none" }}
      </p>
      <p class="no-margin">
        Warranty: {{ form.warranty ? form.warranty : "none" }}
      </p>
      <p class="no-margin">
        Insurance: {{ form.insurance ? form.insurance : "none" }}
      </p>
      <p class="no-margin">
        Net Weight: {{ form.net_weight ? form.net_weight : "none" }}
      </p>
      <div class="col-6 justify-content mt-4 text-align-left">
        <h2>Attributes</h2>
        <p
          class="no-margin"
          v-for="(attribute, index) in form.value"
          :key="index"
        >
          {{ attribute.name }} : {{ attribute.value }}
        </p>
      </div>
    </div>
    <aside class="sidebar" style="max-height: 300px; overflow-y: auto">
      <h2>Item History</h2>
      <div v-for="history in histories" :key="history.id">
        <p class="no-margin">Status: {{ history.status }}</p>
        <p class="no-margin">
          Employee: {{ history.employee.first_name }}
          {{ history.employee.last_name }}
        </p>
        <p class="no-margin">Remarks: {{ history.remarks }}</p>
        <p class="no-margin">
          Issued Date: {{ formatDate(history.issued_at) }}
        </p>
        <p class="no-margin">
          a Return Date:
          {{
            history.return_at
              ? formatDate(history.return_at)
              : "not yet returned"
          }}
        </p>

        <p></p>
      </div>
    </aside>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import { formatDate } from "../../helper.js";
import { itemDetails } from "../../store/itemjs/itemdetails.js";

const {
  fetchEmployeeData,
  fetchHistories,
  getItems,
  getAttributes,
  history,
  addAttribute,
  removeAttribute,
  form,
  histories,
  historyId,
  status,
} = itemDetails();
</script>

<style scoped>
@import url("./resources/css/itemdetails.css");
</style>

