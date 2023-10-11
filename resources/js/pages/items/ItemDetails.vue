<template>
  <div
    class="card ml-3 mt-3"
    style="width: 100%; max-width: 98rem; height: 55rem"
  >
    <div class="card-body text-center">
      <h5 class="">Item Details</h5>
      <div class="">
        <img
          :src="generateBarcode(form.barcode)"
          alt="Barcode"
          style="height: 200px"
        />
      </div>
      <p>Name: {{ form.name }}</p>
      <p>Serial: {{ form.serial }}</p>
      <p>Status: {{ form.status }}</p>
      Attributes:
      <div v-for="(attribute, index) in form.value" :key="index">
        <p>{{ attribute.name }}: {{ attribute.value }}</p>
      </div>
    </div>
  </div>
</template>


<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import JsBarcode from "jsbarcode";

const generateBarcode = (barcodeValue) => {
  const canvas = document.createElement("canvas");
  JsBarcode(canvas, barcodeValue, {
    format: "CODE128",
    displayValue: true,
  });
  return canvas.toDataURL();
};

const errors = ref([]);
const toastr = useToastr();
const router = useRouter();
const route = useRoute();
const form = reactive({
  name: "",
  serial: "",
  status: "",
  parent_id: "",
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
        form.name = response.data.name;
        form.serial = response.data.serial;
        form.status = response.data.status;
        form.parent_id = response.data.parent_id;
        form.barcode = response.data.barcode;
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

