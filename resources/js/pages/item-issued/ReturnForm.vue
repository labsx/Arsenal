<template>
  <ContentHeader title="Issue Item" data="item" datas="issue" />

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
                  <label for="appName">Id</label>
                  <input
                    v-model="form.item_id"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter app display name"
                  />
                </div>
               

                <div class="form-group">
                  <label for="appName">Remarks</label>
                  <input
                    v-model="form.remarks"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter app display name"
                  />
                </div>


                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" v-model="form.status">
                    <option value="" disabled>Select status</option>
                    <option value="operating"> operating </option>
                    <option value="under repair"> under repair </option>
                    <option value="decommission"> decommission </option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="appName">Date Return</label>
                  <input
                    v-model="form.return_date"
                    type="date"
                    class="form-control flatpickr"
                    id="appName"
                    placeholder="Enter app display name"
                    style="background-color: white"
                  />
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

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);
const form = reactive({
item_id: "",
remarks: "",
status: "",
return_date: "",
});

const returnItem = () => {
  axios.get(`/return/${route.params.id}`).then(({ data }) => {
    form.item_id = data.id;
    form.issued_date = data.issued_date;
  });
};

const UpdateHistory = () => {
    console.log('Form Data:', form);
  axios
    .put(`/issue/${route.params.id}`, form) 
    .then((response) => {
      toastr.success("Return item successfully!");
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

onMounted(() => {
  returnItem();

  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "Y-m-d h:i K",
    defaultHour: 10,
  });

});
</script>


