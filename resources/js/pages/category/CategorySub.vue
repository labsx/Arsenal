<template>
  <div
    class="modal fade"
    id="createParent"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createParent"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createParent">CATEGORY SUB</h5>
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
                              <label>Item name</label>
                              <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                placeholder="Enter Categoy Sub (ex. Laptop, Desktop)"
                                :class="{ 'is-invalid': errors.name }"
                              />
                              <span
                                v-if="errors && errors.name"
                                class="text-danger text-sm"
                                >{{ errors.name[0] }}</span
                              >
                            </div>
                          </div>

                           <div class="col-md-12">
                            <div class="form-group">
                              <label for="client">Category</label>
                              <select
                                id="client"
                                class="form-control"
                                v-model="form.category_id"
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
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button
            @click="createParent()"
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
import axios from "axios";
import { onMounted, ref } from "vue";
import { useToastr } from "../../toastr";

const form = ref({
 name: '',
 category_id: "",
});
const errors = ref([]);
const toastr = useToastr();

const createParent = () => {
  axios
    .post("/parent", form.value)
    .then((response) => {
      toastr.success("Items created successfully!");
      $("#createParent").modal("hide");
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

const categories = ref([]);

const getCategories = () => {
  axios.get('/category-data')
    .then((response) => {
      categories.value = response.data;
    })
    .catch((error) => {
      console.error('Error fetching categories:', error);
    });
};
onMounted(() => {
  getCategories();
});
</script>
