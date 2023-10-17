<template>
  <ContentHeader title="" data="category" datas="edit" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Category</h3>
            </div>
            <form>
              <div class="card-body">
                <div class="form-group">
                  <label for="appName">Category Name</label>
                  <span class="text-danger"> *</span>
                  <input
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter category name"
                    :class="{ 'is-invalid': errors.name }"
                  />
                  <span
                    v-if="errors && errors.name"
                    class="text-danger text-sm"
                    >{{ errors.name[0] }}</span
                  >
                </div>

                <div class="form-group">
                  <label for="dateFormat">Group Fields</label>
                  <span class="text-danger"> *</span>
                  <select class="form-control" v-model="form.field_group_id">
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

              <div class="card-footer">
                <button
                  @click.prevent="saveCategory"
                  type="submit"
                  class="btn btn-primary"
                >
                  <i class="fa fa-save mr-1"></i>Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { reactive, onMounted, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);

const form = reactive({
  name: "",
  field_group_id: "",
});

const ItemDetails = () => {
  axios
    .get(`/category/${route.params.id}/show`)
    .then(({ data }) => {
      console.log("Category data:", data);
      if (data && data.name) {
        form.name = data.name;
        form.field_group_id = data.field_group_id;
      } else {
        console.error("Category name not found in the response data.");
      }
    })
    .catch((error) => {
      console.error("Error fetching category details:", error);
    });
};

const saveCategory = () => {
  axios
    .put(`/category/${route.params.id}`, {
      name: form.name,
      field_group_id: form.field_group_id,
    })
    .then(() => {
      toastr.success("Category updated successfully!");
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
    });
};

const field_groups = ref([]);
field_groups;
const getFieldGroup = () => {
  axios
    .get("/fields")
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching field_group:", error);
    });
};

onMounted(() => {
  getFieldGroup();
  ItemDetails();
});
</script>
