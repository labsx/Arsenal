<template>
  <div
    class="modal fade"
    id="createParent"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createParent"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 70%">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createParent">PARENT CATEGORY</h5>
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
                          <div class="col-md-6">
                         
                       
                            <div class="form-group">
                              <label>Item name</label>
                              <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                placeholder="Enter category name"
                              />
                              <span
                                v-if="errors && errors.name"
                                class="text-danger text-sm"
                                >{{ errors.name[0] }}</span
                              >
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button
            @click="createParent()"
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
import { useToastr } from "../../toastr";

const form = ref({
 name: '',
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
      // getItemsFn();
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        toastr.error(message);
        // getItemsFn();
        errors.value = [];
      }
    });
};

</script>
