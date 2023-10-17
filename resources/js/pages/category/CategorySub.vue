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
          <h5 class="modal-title" id="createParent">Category List</h5>
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
                              <label>Category list name</label>
                              <span class="text-danger"> *</span>
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
                          <input
                            v-model="form.category_id"
                            style="display: none"
                          />
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
import { onMounted, ref, defineProps, reactive } from "vue";
import { useToastr } from "../../toastr";
import { useRouter, useRoute } from "vue-router";

const { getFilterParentFn } = defineProps(["getFilterParentFn"]);
const router = useRouter();
const route = useRoute();

const form = reactive({
  name: "",
  category_id: "",
});
const errors = ref([]);
const toastr = useToastr();
const clearForm = () => {
  form.name = "";
};

const createParent = () => {
  const formData = {
    name: form.name,
    category_id: form.category_id,
  };

  axios
    .post("/parent", formData)
    .then((response) => {
      toastr.success("Fields created successfully!");

      getFilterParentFn();
      $("#createParent").modal("hide");
      clearForm();
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      }
    });
};

const categories = ref([]);

const getCategories = () => {
  axios
    .get(`/category/${route.params.id}`)
    .then(({ data }) => {
      console.log("Fields data:", data);
      form.category_id = data.id;
    })
    .catch((error) => {
      console.error("Error fetching category details:", error);
    });
};

onMounted(() => {
  getCategories();
});
</script>
