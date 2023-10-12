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
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title">Item Name</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.item_name"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item name"
                        :class="{ 'is-invalid': errors.item_name }"
                      />
                      <span
                        v-if="errors && errors.item_name"
                        class="text-danger text-sm"
                        >{{ errors.item_name[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="serial">Serial</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.serial"
                        type="text"
                        class="form-control"
                        id="serial"
                        placeholder="Enter item serial number"
                        :class="{ 'is-invalid': errors.serial }"
                      />
                      <span
                        v-if="errors && errors.serial"
                        class="text-danger text-sm"
                        >{{ errors.serial[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="title">Model</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.model"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item model number"
                        :class="{ 'is-invalid': errors.model }"
                      />
                      <span
                        v-if="errors && errors.model"
                        class="text-danger text-sm"
                        >{{ errors.model[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="title">Mfg Date</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.mfg_date"
                        type="date"
                        class="form-control"
                        id="title"
                        placeholder="Enter item mfg_date number"
                        :class="{ 'is-invalid': errors.mfg_date }"
                      />
                      <span
                        v-if="errors && errors.mfg_date"
                        class="text-danger text-sm"
                        >{{ errors.mfg_date[0] }}</span
                      >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="price">Unit price</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.price"
                        type="text"
                        class="form-control"
                        id="price"
                        placeholder="Enter item price number"
                        :class="{ 'is-invalid': errors.price }"
                      />
                      <span
                        v-if="errors && errors.price"
                        class="text-danger text-sm"
                        >{{ errors.price[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Status</label>
                      <span class="text-danger"> *</span>
                      <select
                        v-model="form.status"
                        id="client"
                        class="form-control"
                        :class="{ 'is-invalid': errors.status }"
                      >
                        <option value="" disabled selected hidden>
                          Select Status
                        </option>
                        <option value="operating">Operating</option>
                        <option value="decommissioned">Decommissioned</option>
                        <option value="under repair">Under Repair</option>
                      </select>
                      <span
                        v-if="errors && errors.status"
                        class="text-danger text-sm"
                        >{{ errors.status[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Choose</label>
                      <span class="text-danger"> *</span>
                      <select
                        id="fieldGroup"
                        class="form-control"
                        v-model="form.parent_id"
                        :class="{ 'is-invalid': errors.parent_id }"
                      >
                        <optgroup
                          v-for="subcategory in subcategories"
                          :key="subcategory.id"
                          :label="subcategory.name"
                        >
                          <option value="" disabled selected hidden>
                            Choose item list
                          </option>
                          <option
                            v-for="parentModel in subcategory.parent_models"
                            :key="parentModel.id"
                            :value="parentModel.id"
                          >
                            {{ parentModel.name }}
                          </option>
                        </optgroup>
                      </select>

                      <span
                        v-if="errors && errors.parent_id"
                        class="text-danger text-sm"
                        >{{ errors.parent_id[0] }}</span
                      >
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div
                    class="col-md-3"
                    v-for="(field, index) in fieldsData"
                    :key="index"
                  >
                    <div class="form-group">
                      <label class="d-flex align-items-center" for="time">
                        {{ field.label }}
                        <span
                          class="text-danger ml-1"
                          v-if="field.is_required === 'required'"
                          >*</span
                        >
                        <small
                          v-if="field.description"
                          class="form-text text-muted ml-2"
                          >( {{ field.description }} )</small
                        >
                      </label>

                      <input
                        v-model="form.fields[field.label]"
                        type="text"
                        class="form-control"
                        id="time"
                      />
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Select Category</label>
                      <span class="text-danger"> *</span>
                      <select
                        v-model="form.category_id"
                        id="client"
                        class="form-control"
                        :class="{ 'is-invalid': errors.category_id }"
                        @change="getFields"
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
                      <span
                        v-if="errors && errors.category_id"
                        class="text-danger text-sm"
                        >{{ errors.category_id[0] }}</span
                      >
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm">
                  <i class="fa fa-save mr-2"></i>Save
                </button>
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
const errors = ref([]);

const form = ref({
  category_id: "",
  item_name: "",
  parent_id: "",
  price: "",
  mfg_date: "",
  model: "",
  serial: "",
  status: "",
  fields: {},
});

const createItem = () => {
  const dataToSave = {
    category_id: form.value.category_id,
    parent_id: form.value.parent_id,
    item_name: form.value.item_name,
    price: form.value.price,
    mfg_date: form.value.mfg_date,
    model: form.value.model,
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
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        toastr.error(message);
        errors.value = [];
      }
    });
};

const fieldsData = ref([]);

const getFields = async () => {
  const selectedCategoryId = form.value.category_id;

  if (selectedCategoryId) {
    try {
      const selectedCategory = categories.value.find(
        (category) => category.id === selectedCategoryId
      );
      const fieldGroupId = selectedCategory.field_group_id;

      const response = await axios.get(`/field-groups/${fieldGroupId}/fields`);
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
  form.value.parent_id = "";
  form.value.serial = "";
  form.value.price = "";
  form.value.model = "";
  form.value.mfg_date = "";
  form.value.status = "";
  form.value.item_name = "";
  form.value.fields = {};
  form.value.category_id = "";
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

const subcategories = ref([]);
const getSubCategory = () => {
  axios
    .get("/parent/sub")
    .then((response) => {
      subcategories.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching sub-category", error);
    });
};

onMounted(() => {
  // getParent();
  getSubCategory();
  getCategory();
});
watch(form.category_id, () => {
  getFields();
});
// watch(form, getFields);
</script>