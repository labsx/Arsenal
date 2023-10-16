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
      <p class="no-margin">Price: ₱ {{ form.price }}</p>
      <p class="no-margin">Mfg. Date: {{ form.mfg_date }}</p>
      <p class="no-margin">Manufacturer: {{ form.manufacturer }}</p>
      <p class="no-margin" v-if="form.location !== ''">
        Location: {{ form.location }}
      </p>
      <p class="no-margin" v-if="form.warranty !== ''">
        Warranty: {{ form.warranty }}
      </p>
      <p class="no-margin" v-if="form.insurance !== ''">
        Insurance: {{ form.insurance }}
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
        <p class="no-margin">
          Employee: {{ history.employee.first_name }}
          {{ history.employee.last_name }}
        </p>
        <p class="no-margin">Remarks: {{ history.remarks }}</p>
        <p class="no-margin">Issued Date: {{ formatDate(history.issued_at) }}</p>
        <p class="no-margin">Return Date: {{ formatDate(history.return_at) }}</p>
        <p class="no-margin">Status: {{ history.status }}</p>
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

const status = ref("");
const historyId = ref("");
const errors = ref([]);
const toastr = useToastr();
const router = useRouter();
const route = useRoute();
const form = reactive({
  name: "",
  serial: "",
  status: "",
  parent_id: "",
  id: "",
  value: [{ name: "", value: "" }],
});

const addAttribute = () => {
  form.value.push({ name: "", value: "" });
};

const removeAttribute = (index) => {
  form.value.splice(index, 1);
};

//
const getItems = () => {
  axios
    .get(`/items/${route.params.id}/show`)
    .then((response) => {
      console.log("Response data:", response.data);

      if (response.data) {
        form.id = response.data.id;
        form.name = response.data.name;
        form.serial = response.data.serial;
        form.status = response.data.status;
        form.model = response.data.model;
        form.mfg_date = response.data.mfg_date;
        form.price = response.data.price;
        form.location = response.data.location;
        form.manufacturer = response.data.manufacturer;
        form.warranty = response.data.warranty;
        form.net_weight = response.data.net_weight;
        form.insurance = response.data.insurance;
        status.value = form.status;
        fetchHistories();
      } else {
        console.error("Item data not found in the response.");
      }
    })
    .catch((error) => {
      console.error("Error fetching item details:", error);
    });
};

const getAttributes = () => {
  axios
    .get(`/items/${route.params.id}/attributes`)
    .then(({ data }) => {
      console.log("Attributes data:", data);

      if (Array.isArray(data)) {
        form.value = data.map((attribute) => ({
          name: attribute.name,
          value: attribute.value,
        }));
      } else {
        console.error("Invalid attributes data format.");
      }
    })
    .catch((error) => {
      console.error("Error fetching item attributes:", error);
    });
};

const histories = ref([]);
const fetchHistories = () => {
  console.log("Fetching histories for item with ID:", form.id);

  if (form.id) {
    axios
      .get(`/histories?item_id=${form.id}`)
      .then(async ({ data }) => {
        console.log("Histories data:", data);
        if (data.length > 0) {
          historyId.value = data[0].id;

          for (let i = 1; i < data.length; i++) {
            if (data[i].id > historyId.value) {
              historyId.value = data[i].id;
            }
          }
        }

        const fetchEmployeeDataPromises = data.map(async (history) => {
          const employeeData = await fetchEmployeeData(history.employee_id);
          if (employeeData) {
            history.employee = employeeData;
          } else {
            history.employee = { first_name: "Unknown", last_name: "Employee" };
          }
          return history;
        });

        Promise.all(fetchEmployeeDataPromises)
          .then((historiesWithEmployee) => {
            histories.value = historiesWithEmployee;
          })
          .catch((error) => {
            console.error("Error fetching employee data:", error);
          });
      })
      .catch((error) => {
        console.error("Error fetching histories data:", error);
      });
  }
};

const fetchEmployeeData = async (employeeId) => {
  console.log("Fetching employee data for employee ID:", employeeId);
  try {
    const response = await axios.get(`/histories/${employeeId}`);
    console.log("Employee data response:", response.data);
    if (response.data) {
      return response.data;
    }
    return null;
  } catch (error) {
    console.error("Error fetching employee data:", error);
    return null;
  }
};

onMounted(() => {
  fetchEmployeeData();
  fetchHistories();
  getItems();
  getAttributes();
});
</script>

<style scoped>
@import url("./resources/css/itemdetails.css");
</style>

