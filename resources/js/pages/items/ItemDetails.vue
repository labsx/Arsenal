<template>
  <div id="pop-up">
    <img
      src="https://github.com/iamshaunjp/css-animations-playlist/blob/master/web-examples/img/ninja.png?raw=true"
      alt=""
    />
    <div class="container">
      <div class="">
        <h3>{{ form.name }}</h3>
        <img
          :src="generateBarcode(form.barcode)"
          alt="Barcode"
          style="height: 130px; width: 300px"
          class="mt-1"
        />
        <div class="row text-align-center ml-5">
          <div class="justify-content mt-3 text-align-left" style="">
            <p class="mt-1 no-margin">Model: {{ form.model }}</p>
            <p class="no-margin">Serial: {{ form.serial }}</p>
            <p class="no-margin">Price: ₱ {{ form.price }}</p>
            <p class="no-margin">Mfg. Date: {{ form.mfg_date }}</p>
            <div class="justify-content mt-3 text-align-left">
              <p
                class="no-margin"
                v-for="(attribute, index) in form.value"
                :key="index"
              >
                {{ attribute.name }} : {{ attribute.value }}
              </p>
            </div>
          </div>
        </div>
        <div class="button float-right">
          <button
            @click="printItem"
            type="submit"
            class="btn btn-primary btn-sm"
          >
            Print item
          </button>
        </div>
      </div>
      <div class="cross"></div>
    </div>
  </div>
</template>


<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import JsBarcode from "jsbarcode";

const printItem = () => {
  const printWindow = window.open("", "_blank");
  if (printWindow) {
    const itemDetailsHtml = `
      <html>
        <head>
        </head>
        <body>
          <div>
            <img src="${generateBarcode(
              form.barcode
            )}" alt="Barcode" style="height: 200px" />
          </div>
          <p>Name: ${form.name}</p>
          <p>Serial: ${form.serial}</p>
          <p>Model: ${form.model}</p>
          <p>Attributes:</p>
          <ul>
            ${form.value
              .map(
                (attribute) => `<li>${attribute.name}: ${attribute.value}</li>`
              )
              .join("")}
          </ul>
        </body>
      </html>
    `;

    printWindow.document.write(itemDetailsHtml);
    printWindow.document.close();
    printWindow.print();
  } else {
    console.error("Failed to open the print window.");
  }
};

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
        form.model = response.data.model;
        form.mfg_date = response.data.mfg_date;
        form.price = response.data.price;
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
@import url("./resources/css/itemdetails.css");
</style>

