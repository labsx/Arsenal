<template>
  <div
    class="modal fade"
    id="createFieldsGroup"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createFieldsGroup"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createFieldsGroup">Add Fields</h5>
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
                          <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="title">Name</label>
                              <input
                                type="text"
                                class="form-control"
                                id="title"
                                placeholder="Enter item name"
                                v-model="form.name"
                              />
                              <span
                                v-if="errors && errors.name"
                                class="text-danger text-sm"
                                >{{ errors.name[0] }}</span
                              >
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Enter description"
                            v-model="form.description"
                          ></textarea>
                          <span
                            v-if="errors && errors.description"
                            class="text-danger text-sm"
                            >{{ errors.description[0] }}</span
                          >
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
          <button @click="createFields()" type="submit" class="btn btn-primary">
            <i class="fa fa-save mr-2"></i>Save Item
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { useToastr } from "../../toastr";

const form = ref({
  name: "",
  description: "",
});
const errors = ref([]);
const toastr = useToastr();

const clearForm = () => {
  form.name = "";
  form.description = "";
};

const createFields = () => {
  axios
    .post("/field-group", form.value)
    .then((response) => {
      toastr.success("fields created successfully!");
      $("#createFieldsGroup").modal("hide");
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
</script>
