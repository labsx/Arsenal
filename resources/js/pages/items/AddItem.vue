<template>
  <form @submit.prevent="createItem">
    <label for="item_name">Item Name</label>
    <input v-model="form.item_name" type="text" id="item_name" />

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="fieldGroup">Select Category</label>
          <select v-model="form.category_id" id="fieldGroup">
            <option value=""></option>
            <option
              :value="category.id"
              v-for="category in categories"
              :key="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="fieldGroup">Select Fields</label>
          <select v-model="form.item_id" id="fieldGroup" @change="getFields">
            <option value=""></option>
            <option
              :value="group.id"
              v-for="group in field_groups"
              :key="group.id"
            >
              {{ group.name }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div v-for="(field, index) in fieldsData" :key="index">
      <label>{{ field.label }} : </label>
      <input
        v-model="form.fields[field.label]"
        type="text"
        class="form-control"
      />
    </div>
    <button type="submit" class="btn btn-primary">
      <i class="fa fa-save mr-2"></i>Save Item
    </button>
  </form>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch } from "vue";
import { useToastr } from "../../toastr";

const toastr = useToastr();

const form = ref({
  category_id: "",
  item_name: "",
  fields: {},
});

const createItem = () => {
  const dataToSave = {
    category_id: form.value.category_id,
    item_name: form.value.item_name,
    value: Object.keys(form.value.fields).map((label) => ({
      label,
      value: form.value.fields[label],
    })),
  };

  axios
    .post("/item-attributes", dataToSave)
    .then((response) => {
      toastr.success("Item saved successfully!");
      clearForm();
    })
    .catch((error) => {
      toastr.error("Error saving item: " + error);
    });
};

const field_groups = ref([]);
const fieldsData = ref([]);

const getFieldGroup = () => {
  axios
    .get("/field-group")
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching field_group:", error);
    });
};

const getFields = async () => {
  const selectedGroupId = form.value.item_id;

  if (selectedGroupId) {
    try {
      const response = await axios.get(
        `/fields?field_groups_id=${selectedGroupId}`
      );
      fieldsData.value = response.data;
    } catch (error) {
      console.error("Error fetching fields:", error);
    }
  } else {
    fieldsData.value = [];
  }
};

const clearForm = () => {
  form.value.item_id = "";
  form.value.item_name = "";
  form.value.fields = {};
};

const categories = ref();
const getCategory = () => {
  axios
    .get("/category-data")
    .then((response) => {
      categories.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching field_group:", error);
    });
};

onMounted(() => {
  getFieldGroup();
  getCategory();
});

watch(form, getFields);
</script>
