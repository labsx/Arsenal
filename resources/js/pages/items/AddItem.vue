<template>
  <ContentHeader title="Add Item" data="item" datas="add" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form form @submit.prevent="createItem">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="client">Select category</label>
                    <span class="text-danger"> *</span>
                    <select
                      id="fieldGroup"
                      class="form-control"
                      v-model="form.parent_id"
                      @change="getFields"
                      :class="{ 'is-invalid': errors.parent_id }"
                    >
                      <optgroup
                        v-for="subcategory in subcategories"
                        :key="subcategory.id"
                        :label="subcategory.name"
                      >
                        <option
                          value=""
                          disabled
                          selected
                          hidden
                          class="text-center"
                        >
                          Choose Category
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
                        class="form-control flatpickr"
                        id="title"
                        placeholder="Select manufacturing date"
                        :class="{ 'is-invalid': errors.mfg_date }"
                        style="background: white"
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
                      <label for="price">Manufacturer</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.manufacturer"
                        type="text"
                        class="form-control"
                        id="Manufacturer"
                        placeholder="Enter item manufacturer"
                        :class="{ 'is-invalid': errors.manufacturer }"
                      />
                      <span
                        v-if="errors && errors.manufacturer"
                        class="text-danger text-sm"
                        >{{ errors.manufacturer[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="price">Manufacturer address</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.location"
                        type="text"
                        class="form-control"
                        id="location"
                        placeholder="Enter item manufacturer address"
                        :class="{ 'is-invalid': errors.location }"
                      />
                      <span
                        v-if="errors && errors.location"
                        class="text-danger text-sm"
                        >{{ errors.location[0] }}</span
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
                        placeholder="₱"
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
                      <label class="d-flex align-items-center"
                        >Warranty
                        <small class="form-text text-muted ml-2"
                          >( enter days/months/year )</small
                        >
                      </label>
                      <input
                        v-model="form.warranty"
                        type="text"
                        class="form-control"
                        id="price"
                        placeholder="Enter item warranty"
                        :class="{ 'is-invalid': errors.warranty }"
                      />
                      <span
                        v-if="errors && errors.warranty"
                        class="text-danger text-sm"
                        >{{ errors.warranty[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="d-flex align-items-center"
                        >Net. Weight
                        <small class="form-text text-muted ml-2"
                          >( enter only number in kg )</small
                        >
                      </label>
                      <input
                        v-model="form.net_weight"
                        type="text"
                        class="form-control"
                        id="price"
                        placeholder="Enter item net weight in kg"
                        :class="{ 'is-invalid': errors.net_weight }"
                      />
                      <span
                        v-if="errors && errors.net_weight"
                        class="text-danger text-sm"
                        >{{ errors.net_weight[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="price">Insurance</label>
                      <input
                        v-model="form.insurance"
                        type="text"
                        class="form-control"
                        id="insurance"
                        placeholder="Enter item insurance"
                        :class="{ 'is-invalid': errors.insurance }"
                      />
                      <span
                        v-if="errors && errors.insurance"
                        class="text-danger text-sm"
                        >{{ errors.insurance[0] }}</span
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

                <div class="row"></div>
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
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const toastr = useToastr();
const errors = ref([]);
const fieldsData = ref([]);

const form = ref({
  category_id: "",
  item_name: "",
  parent_id: "",
  price: "",
  mfg_date: "",
  model: "",
  serial: "",
  status: "",
  manufacturer: "",
  location: "",
  warranty: "",
  insurance: "",
  net_weight: "",
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
    manufacturer: form.value.manufacturer,
    location: form.value.location,
    warranty: form.value.warranty,
    insurance: form.value.insurance,
    net_weight: form.value.net_weight,
    value: Object.keys(form.value.fields).map((label) => ({
      label,
      value: form.value.fields[label],
    })),
  };

  axios
    .post("/items", dataToSave)
    .then((response) => {
      toastr.success("Item created successfully!");
      clearForm();
      errors.value = "";
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        toastr.error(message);
        errors.value = [];
      }
      s;
    });
};

const getFields = async () => {
  const selectedSubcategoryId = form.value.parent_id;

  if (selectedSubcategoryId) {
    try {
      const selectedSubcategory = subcategories.value.find((subcategory) =>
        subcategory.parent_models.some(
          (model) => model.id === selectedSubcategoryId
        )
      );
      const fieldGroupId = selectedSubcategory.field_group_id;
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
  form.value.manufacturer = "";
  form.value.location = "";
  form.value.warranty = "";
  form.value.net_weight = "";
};

const categories = ref();
const getCategory = () => {
  axios
    .get("/category")
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
  getSubCategory();
  getCategory();

  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "Y-m-d h:i K",
    defaultHour: 10,
  });
});
watch(form.category_id, () => {
  getFields();
});
</script>
