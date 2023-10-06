<template>
  <div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Label</th>
          <th scope="col">Field Group Id</th>
          <th scope="col">Description</th>
        </tr>
      </thead>
      <tbody v-if="fields.length > 0">
        <tr v-for="(field, index) in fields" :key="field.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ field.label }}</td>
          <td>{{ field.field_groups_id }}</td>
          <td>{{ field.description }}</td>
        </tr>
      </tbody>
      <div v-else>No data available</div>
    </table>
  </div>

  <!-- <h3>Field Information</h3>
  <div>
    <label for="">label</label>
    <input v-model="form.label" type="text" name="" id="" />

    <label for="">description</label>
    <input v-model="form.description" type="text" name="" id="" />

    <label for="">select</label>
    <select v-model="form.is_required" name="" id="">
      <option value="required">required</option>
      <option value="not required" not required></option>
    </select>

    <button type="submit" @click.prevent="createField()">Save</button>
  </div> -->

  <button
    class="btn btn-primary"
    data-toggle="modal"
    data-target="#createFields"
  >
    <i class="fa fa-plus-circle mr-1"></i>Add Fields
  </button>

  <div
    class="modal fade"
    id="createFields"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createFields"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 70%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createFields">ADD ITEM</h5>
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
                        <label for="">select category</label>
                        <select name="" id="" v-model="form.field_groups_id">
                          <option value=""></option>
                          <option
                            :value="field.id"
                            v-for="field in field_groups"
                            :key="field.id"
                          >
                            {{ field.name }}
                          </option>
                        </select>

                        <h3>Field Information</h3>
                        <div>
                          <label for="">label</label>
                          <input
                            v-model="form.label"
                            type="text"
                            name=""
                            id=""
                          />

                          <label for="">description</label>
                          <input
                            v-model="form.description"
                            type="text"
                            name=""
                            id=""
                          />

                          <label for="">select</label>
                          <select v-model="form.is_required" name="" id="">
                            <option value="required">required</option>
                            <option value="not required">not required</option>
                          </select>
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
import { ref, onMounted, getCurrentInstance } from "vue";
import { useToastr } from "../../toastr";

const toastr = useToastr();

const route = getCurrentInstance().proxy.$route;
const fields = ref([]);
const errors = ref([]);
//display fields by id
const getFieldsById = () => {
  const fieldId = route.params.id;

  axios
    .get(`/fields/${fieldId}/show`)
    .then((response) => {
      fields.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};
//save the fields
const form = ref({
  name: "",
  description: "",
  is_required: "",
  field_groups_id: "",
  field_id: "",
});

const createField = () => {
  const formData = {
    label: form.value.label,
    description: form.value.description,
    is_required: form.value.is_required,
    field_groups_id: form.value.field_groups_id,  // Use form.field_groups_id here
  };

  axios
    .post("/fields", formData)
    .then((response) => {
      toastr.success("Fields created successfully!");
      // Clear the form or perform any other necessary actions
      clearForm();
      // Refresh the list of fields
      getFieldsById();
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        toastr.error("Validation error. Please check your inputs.");
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
    .get("/field-group")
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

onMounted(() => {
  getFieldsById();
  getFieldsGroups();
});
</script>
