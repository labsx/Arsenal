<template>
  <div class="col-6 justify-content mt-3 text-align-left">
    <p>Item id: {{ form.id }}</p>
    <p>Item Name : {{ form.name }}</p>
    <p class="mt-1 no-margin">Model: {{ form.model }}</p>
    <p class="no-margin">Serial: {{ form.serial }}</p>
    <p class="no-margin">Price: ₱ {{ form.price }}</p>
    <p class="no-margin">Mfg. Date: {{ form.mfg_date }}</p>
    <p class="no-margin">Status: {{ form.status }}</p>
  </div>
  <div class="col-6 justify-content mt-4 text-align-left">
    <p class="no-margin" v-for="(attribute, index) in form.value" :key="index">
      {{ attribute.name }} : {{ attribute.value }}
    </p>
  </div>

  <h2>History Data</h2>
  <ul>
    <li v-for="history in histories" :key="history.id">
      <p>History ID: {{ history.id }}</p>
      <p>
        Employee: {{ history.employee.first_name }}
        {{ history.employee.last_name }}
      </p>
      <p>Remarks: {{ history.remarks }}</p>
      <p>Issued Date: {{ history.issued_date }}</p>
      <p>Return Date: {{ history.return_date }}</p>
      <p>Return Date: {{ history.status }}</p>
    </li>
  </ul>

  <router-link
    v-if="status !== 'under repair'"
    :to="
      status === 'operating'
        ? `/admin/items/${form.id}/issue`
        : `/admin/items/${form.id}/return`
    "
    class="btn btn-info"
  >
    <i class="fas fa-edit"></i>
    {{ status === "operating" ? "Issue" : "Return" }}
  </router-link>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";

const status = ref("");

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
/* @import url("./resources/css/itemdetails.css"); */
</style>

