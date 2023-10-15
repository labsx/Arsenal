<template>
  <ContentHeader title="Issue Item" data="item" datas="issue" />

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Issue item</h3>
            </div>

            <form>
              <div class="card-body">
                <div class="form-group">
                  <input
                    v-model="form.item_id"
                    type="text"
                    class="form-control"
                    item_="appName"
                    placeholder="Enter app display name"
                    style="display: none"
                  />
                </div>

                <div class="form-group">
                  <label>Employee List</label>
                  <select class="form-control" v-model="form.employee_id">
                    <option value="" disabled>Select an employee</option>
                    <option
                      v-for="employee in employees"
                      :key="employee.id"
                      :value="employee.id"
                    >
                      {{ employee.first_name }} {{ employee.last_name }}
                    </option>
                  </select>
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
                  <label for="appName">Date Issued</label>
                  <input
                    v-model="form.issued_date"
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
                  @click.prevent="saveIssue"
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
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import { formatDate } from "../../helper.js";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);
const form = reactive({
  item_id: "",
  employee_id: "",
  issued_date: "",
  remarks: "",
});

const getItemsData = () => {
  axios.get(`/issue/${route.params.id}`).then(({ data }) => {
    form.item_id = data.id;
  });
};

const employees = ref([]);
const getEmployee = () => {
  axios
    .get("/issue")
    .then((response) => {
      employees.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching employees:", error);
    });
};

const saveIssue = () => {
  axios
    .post("/issue", form)
    .then((response) => {
      toastr.success("Successfully issued item!");
      // router.push("/admin/items/issue/list");
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
  getItemsData();
  getEmployee();

  flatpickr(".flatpickr", {
    enableTime: true,
    dateFormat: "Y-m-d h:i K",
    defaultHour: 10,
  });
});
</script>


