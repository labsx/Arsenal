<template>
  <form>
    <div class="form-group">
      <label for="item_name">Item Name:</label>
      <input
        v-model="form.name"
        type="text"
        class="form-control"
        id="name"
        required
      />
    </div>
    <div class="form-group">
      <label for="serial">Serial:</label>
      <input
        v-model="form.serial"
        type="text"
        class="form-control"
        id="serial"
        required
      />
    </div>
    <div class="form-group">
      <label for="status">Status:</label>
      <input
        v-model="form.status"
        type="text"
        class="form-control"
        id="status"
        required
      />
    </div>

    <!-- Display attributes -->
    <div class="form-group">
      <label for="attributes">Attributes:</label>
      <button type="button" class="btn btn-primary" @click="addAttribute">
        Add Attribute
      </button>
      <div id="attributes-container">
        <div
          v-for="(attribute, index) in form.value"
          :key="index"
          class="attribute"
        >
          <input
            v-model="attribute.name"
            type="text"
            class="formm-control"
            :name="`value[${index}][label]`"
            placeholder="Attribute Label"
            required
          />
          <input
            v-model="attribute.value"
            type="text"
            class="form-control"
            :name="`value[${index}][value]`"
            placeholder="Attribute Value"
          />
          <button
            type="button"
            class="btn btn-danger"
            @click="removeAttribute(index)"
          >
            Remove
          </button>
        </div>
      </div>
    </div>

    <button
      @click.prevent="handleSubmit()"
      type="submit"
      class="btn btn-primary"
    >
      Submit
    </button>
  </form>
</template>


<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";

const toastr = useToastr();
const router = useRouter();
const route = useRoute();
const form = reactive({
  name: "",
  serial: "",
  status: "",
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
      console.log("Response data:", response.data); // Check the response data

      if (response.data) {
        form.name = response.data.name;
        form.serial = response.data.serial;
        form.status = response.data.status;
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
//edit the item
const handleSubmit = () => {
  console.log("Form submitted with data:", form.value);

  axios
    .put(`/items/${route.params.id}`, form)
    .then((response) => {
      toastr.success("Item updated successfully!");
    })
    .catch((error) => {
      toastr.error("Error updating item. Please try again.");
    });
};
onMounted(() => {
  getItems();
  getAttributes();
});
</script>

