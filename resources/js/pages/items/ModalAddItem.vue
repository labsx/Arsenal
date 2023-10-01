<template>
  <div
    class="modal fade"
    id="createModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 70%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ADD ITEM</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form @submit.prevent="createItem()">
                        <div class="row">
                          <div class="col-md-6">
                            <FormText
                              label="Item Name"
                              placeholder="Enter item name "
                              inputType="text"
                              :value="form.name"
                              :errors="errors"
                              errorKey="name"
                              @update:value="updateFormName"
                            />
                          </div>
                          <div class="col-md-6">
                            <FormText
                              label="Serial (Optional)"
                              placeholder="Enter item serial"
                              inputType="text"
                              :value="form.serial"
                              :errors="errors"
                              errorKey="serial"
                              @update:value="updateFormSerial"
                            />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <FormText
                              label="Date"
                              inputType="date"
                              placeholder="Select date"
                              :value="form.date"
                              :errors="errors"
                              errorKey="date"
                              @update:value="updateFormDate"
                            />
                          </div>

                          <div class="col-md-3">
                            <FormText
                              label="Item Count"
                              inputType="integer"
                              placeholder="Enter items count "
                              :value="form.count"
                              :errors="errors"
                              errorKey="count"
                              @update:value="updateFormCount"
                            />
                          </div>
                          <div class="col-md-6">
                            <FormText
                              label="Model (Optional)"
                              inputType="text"
                              placeholder="Enter item model"
                              Text
                              :value="form.model"
                              :errors="errors"
                              errorKey="model"
                              @update:value="updateFormModel"
                            />
                          </div>
                        </div>
                        <FormText
                          label="Description"
                          placeholder="Enter item description"
                          inputType="text"
                          :value="form.description"
                          :errors="errors"
                          errorKey="description"
                          rows="5"
                          @update:value="updateFormDescription"
                        />
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button @click="createItem" type="submit" class="btn btn-primary">
            <i class="fa fa-save mr-2"></i>Save Item
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, defineProps, onMounted } from "vue";
import { useToastr } from "../../toastr";
import FormText from "../../pages/items/item-components/FormTextAddItem.vue";

const updateFormName = (newValue) => {
  form.value.name = newValue;
};
const updateFormSerial = (newValue) => {
  form.value.serial = newValue;
};
const updateFormDate = (newValue) => {
  form.value.date = newValue;
};
const updateFormCount = (newValue) => {
  form.value.count = newValue;
};
const updateFormModel = (newValue) => {
  form.value.model = newValue;
};
const updateFormDescription = (newValue) => {
  form.value.description = newValue;
};

const { getItemsFn } = defineProps(["getItemsFn"]);
const toastr = useToastr();
const errors = ref([]);
const form = ref({
  name: "",
  serial: "",
  date: "",
  model: "",
  count: "",
  description: "",
});

const createItem = () => {
  axios
    .post("/items", form.value)
    .then((response) => {
      toastr.success("Item created successfully!");
      $("#createModal").modal("hide");
      clearForm();
      getItemsFn();
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        toastr.error(message);
        getItemsFn();
        errors.value = [];
      }
    });
};

const clearForm = () => {
  form.value.name = "";
  form.value.serial = "";
  form.value.date = "";
  form.value.model = "";
  form.value.description = "";
  form.value.count = "";
};
</script>

