<template>
  <div
    class="modal fade"
    id="createCategory"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createCategory"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createCategory">ADD NEW CATEGORY</h5>
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
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="title">Category Name</label>
                              <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                id="title"
                                placeholder="Enter category name"
                                :class="{ 'is-invalid': errors.name }"
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
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="client">Parent Category</label>
                            <select
    id="client"
    class="form-control"
    v-model="form.parent_id"
    name="parent_id"
>
    <option value="" disabled selected hidden>
        Select Parent
    </option>
    <option v-for="category in filterCategory" :key="category.id" :value="category.id">{{ category.name }}</option>
</select>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="client">Fields Group</label>
                              <select
                                id="client"
                                class="form-control"
                                v-model="form.field_groups_id"
                              >
                                <option value="" disabled selected hidden>
                                  Select Field Groups
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
          <button
            type="button"
            class="btn btn-outline-secondary btn-sm"
            data-dismiss="modal"
          >
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button
            @click="createItem"
            type="submit"
            class="btn btn-outline-primary btn-sm"
          >
            <i class="fa fa-save mr-2"></i>Save Item
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from "vue";
// import { addCategory } from "../../store/categoryjs/categoryadd.js";

 const { getCategoryFn } = defineProps(["getCategoryFn"]);
// const { errors, form, categories, filterCategory, getCategory,  getFieldGroup, field_groups, createItem } =
//   addCategory(getCategoryFn);

import axios from "axios";
import { ref, onMounted, reactive, computed } from "vue";
import { useToastr } from "../../toastr";

    const toastr = useToastr();
    const errors = ref([]);
    const form = reactive({
        name: "",
        field_groups_id: "",
        parent_id: "",
    });

 const createItem = () => {
    const formData = {
        name: form.name,
        field_group_id: form.field_groups_id,
        parent_id: form.parent_id,
    };

    axios
        .post("/category", formData)
        .then((response) => {
            toastr.success("Category created successfully!");
            $("#createCategory").modal("hide");
            clearForm();
            getCategoryFn();
            errors.value = [];
        })
        .catch((error) => {
            if (error.response && error.response.status === 400) {
                toastr.error(error.response.data.error);
            } else if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors || {};
            }
        });
};


    const clearForm = () => {
        form.value.name = "";
    };

    const field_groups = ref([]);
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

    const categories = ref([]);

   const getCategory = () => {
   axios.get("/categories")
    .then((response) => {
        categories.value = response.data;
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
  const filterCategory = computed(() => {
    return categories.value.filter(category => category.parent_id === null);
      });

    onMounted(() => {
        getFieldGroup();
        getCategory();
    });
  
</script>
