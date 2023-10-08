<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Create Item</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Item</li>
            <li class="breadcrumb-item active">Create</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form form @submit.prevent="createItem">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="title">Item Name</label>
                      <input
                        v-model="form.item_name"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item name"
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="serial">Serial</label>
                      <input
                        v-model="form.serial"
                        type="text"
                        class="form-control"
                        id="serial"
                      />
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Status</label>
                      <select
                        v-model="form.status"
                        id="client"
                        class="form-control"
                      >
                        <option value="" disabled selected hidden>
                          Select Status
                        </option>
                        <option value="operating">Operating</option>
                        <option value="issued">Issued</option>
                        <option value="decommissioned">Decommissioned</option>
                        <option value="under repair">Under Repair</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Select Category</label>
                      <select
                        v-model="form.category_id"
                        id="client"
                        class="form-control"
                      >
                        <option value="" disabled selected hidden>
                          Select Category
                        </option>
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
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Select Fields</label>
                      <select
                        id="fieldGroup"
                        class="form-control"
                        v-model="form.item_id"
                        @change="getFields"
                      >
                        <option value="" disabled selected hidden>
                          Select Fields
                        </option>
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

                  <div
                    class="col-md-3"
                    v-for="(field, index) in fieldsData"
                    :key="index"
                  >
                    <div class="form-group">
                      <label for="time">{{ field.label }}</label>
                      <span
                        class="text-danger"
                        v-if="field.is_required === 'required'"
                        >*</span
                      >
                      <small class="form-text text-muted">{{
                        field.description
                      }}</small>
                      <input
                        v-model="form.fields[field.label]"
                        type="text"
                        class="form-control"
                        id="time"
                      />
                    </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch } from "vue";
import { useToastr } from "../../toastr";

const toastr = useToastr();

const form = ref({
  category_id: "",
  item_name: "",
  serial: "",
  status: "",
  fields: {},
});

const createItem = () => {
  const dataToSave = {
    category_id: form.value.category_id,
    item_name: form.value.item_name,
    serial: form.value.serial,
    status: form.value.status,
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
    .get("/field-group/name")
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
