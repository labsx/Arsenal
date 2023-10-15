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
        form.parent_id = response.data.parent_id;
        form.barcode = response.data.barcode;
        form.model = response.data.model;
        form.mfg_date = response.data.mfg_date;
        form.price = response.data.price;

        status.value = form.status;
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


onMounted(() => {
  getItems();
  getAttributes();
});
</script>

<style scoped>
/* @import url("./resources/css/itemdetails.css"); */
</style>

