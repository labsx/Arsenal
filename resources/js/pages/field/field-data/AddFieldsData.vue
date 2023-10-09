<template>
  <div
    class="modal fade"
    id="createFieldData"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createFieldData"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createFieldData">ADD FIELDS</h5>
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
                      <form>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="client">Category</label>
                              <select
                                id="client"
                                class="form-control"
                                v-model="form.field_groups_id"
                              >
                                <option value="" disabled selected hidden>
                                  Select Category
                                </option>
                                <option
                                  :value="field.id"
                                  v-for="field in field_groups"
                                  :key="field.id"
                                >
                                  {{ field.name }}
                                </option>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="date">Label</label>
                              <span class="text-danger"> *</span>
                              <input
                                v-model="form.label"
                                type="text"
                                class="form-control"
                                id="text"
                                :class="{ 'is-invalid': errors.label}"
                              />
                               <span
                                v-if="errors && errors.label"
                                class="text-danger text-sm"
                                >{{ errors.label[0] }}</span
                              >
                            </div>
                          </div>

                          <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea
                              class="form-control"
                              id="description"
                              rows="3"
                              v-model="form.description"
                              placeholder="Enter Description"
                            ></textarea>
                          </div>
                          <div class="form-group ml-2">
                            <input v-model="form.is_required" type="checkbox" />
                            <label class="ml-2">required</label>
                          </div>
                        </div>
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
          <button
            @click.prevent="createField()"
            type="submit"
            class="btn btn-primary"
          >
            <i class="fa fa-save mr-2"></i>Save Item
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import Swal from "sweetalert2";
import { useToastr } from "../../../toastr";

const toastr = useToastr();
const errors = ref([]);
//save the fields
const form = ref({
  name: "",
  description: "",
  is_required: "",
  field_groups_id: "",
  field_id: "",
});

const createField = () => {
  const isRequired = form.value.is_required ? "required" : "not required";
  const formData = {
    label: form.value.label,
    description: form.value.description,
    is_required: isRequired,
    field_groups_id: form.value.field_groups_id,
  };

  axios
    .post("/fields", formData)
    .then((response) => {
      toastr.success("Fields created successfully!");
      clearForm();
      $("#createFieldData").modal("hide");
      
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
    });
};

const clearForm = () => {
  form.value.label = "";
  form.value.description = "";
  form.value.is_required = "";
};

//show category
const field_groups = ref();
const getFieldsGroups = () => {
  axios
    .get("/field-group/name")
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

onMounted(() => {
  getFieldsGroups();
});
</script>
