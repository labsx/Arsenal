<template>
  <ContentHeader title="" data="item" datas="return" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Return item</h3>
            </div>

            <form>
              <div class="card-body">
                <div class="form-group">
                  <input
                    v-model="form.history_id"
                    type="text"
                    style="display: none"
                  />
                </div>

                <div class="form-group">
                  <label for="appName">Remarks</label>
                  <input
                    v-model="form.remarks"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter remarks"
                    :class="{ 'is-invalid': errors.remarks }"
                  />
                  <span
                    v-if="errors && errors.remarks"
                    class="text-danger text-sm"
                    >{{ errors.remarks[0] }}</span
                  >
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select
                    class="form-control"
                    v-model="form.status"
                    :class="{ 'is-invalid': errors.status }"
                  >
                    <option value="" disabled>Select status</option>
                    <option value="operating">operating</option>
                    <option value="under repair">under repair</option>
                    <option value="decommissioned">decommissioned</option>
                  </select>
                  <span
                    v-if="errors && errors.status"
                    class="text-danger text-sm"
                    >{{ errors.status[0] }}</span
                  >
                </div>

                <div class="form-group">
                  <label for="appName">Return Date</label>
                  <input
                    v-model="form.return_at"
                    type="date"
                    class="form-control"
                    id="appName"
                    placeholder="Enter return date"
                    style="background-color: white"
                    :class="{ 'is-invalid': errors.return_at }"
                  />
                  <span
                    v-if="errors && errors.return_at"
                    class="text-danger text-sm"
                    >{{ errors.return_at[0] }}</span
                  >
                </div>
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="UpdateHistory"
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
import { reactive, onMounted, ref, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);
const form = reactive({
  history_id: "",
  remarks: "",
  status: "",
  return_at: "",
});

const returnItem = () => {
  axios.get(`/return/${route.params.id}`).then(({ data }) => {
    form.history_id = data.id;
    form.employee_id = data.employee_id;
  });
};

const UpdateHistory = () => {
  console.log("Form Data:", form);
  axios
    .put(`/return/${route.params.id}`, form)
    .then((response) => {
      toastr.success("Return item successfully!");
      errors.value = "";
      router.push("/admin/items/list");
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error(error.response.data.error);
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
      } else {
        toastr.error("An unexpected error occurred. Please try again.");
      }
    });
};

const setCurrentDate = () => {
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, "0");
  const day = String(currentDate.getDate()).padStart(2, "0");

  form.return_at = `${year}-${month}-${day}`;
};

onMounted(() => {
  returnItem();
  setCurrentDate();
});
</script>


