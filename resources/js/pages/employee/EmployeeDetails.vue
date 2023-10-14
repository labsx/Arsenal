<template>
  <ContentHeader title="Employee List" data="employees" datas="details" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <button
                class="btn btn-outline-primary btn-sm"
                data-toggle="modal"
                data-target="#addEmployee"
              >
                <i class="fa fa-plus-circle mr-1"></i>Add employee
              </button>
            </div>
            <div>
              <div class="input-group">
                <input
                  v-model="searchQuery"
                  type="text"
                  class="form-control"
                  placeholder="Search..."
                />
                <div class="input-group-append">
                  <span class="input-group-text"
                    ><i class="fa fa-search text-primary" aria-hidden="true"></i
                  ></span>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table align-middle">
                <thead v-if="employees.data.length > 0">
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Position</th>
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="employees.data.length > 0">
                  <tr v-for="employee in employees.data" :key="employee.id">
                    <td>{{ employee.first_name }}</td>
                    <td>{{ employee.last_name }}</td>
                    <td>{{ employee.position }}</td>
                    <td>
                      <router-link
                        to=""
                        @click.prevent="deleteEmployee(employee.id)"
                      >
                        <i class="fa fa-trash text-danger ml-2"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="8" style="text-align: center">
                      <img
                        v-if="showImage && employees.data.length === 0"
                        :src="imagePath"
                        alt="No Data Found"
                        style="max-width: 750px; height: auto"
                      />
                      <p style="font-weight: bold; color: red">
                        No data found !
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div>
            <Bootstrap4Pagination
              :data="employees"
              @pagination-change-page="getEmployee"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <AddEmployee :getEmployeeFn="getEmployee" />
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch } from "vue";
import Swal from "sweetalert2";
import { deleteEmployees } from "../../store/swal.js";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { useToastr } from "../../toastr";
import AddEmployee from "./AddEmployee.vue";
import { debounce } from "lodash";
import imagePath from "/resources/image/no data.gif";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const showImage = ref(false);
const toastr = useToastr();
const errors = ref([]);
const employees = ref({ data: [] });

const getEmployee = (page = 1) => {
  axios
    .get(`/employee?page=${page}`)
    .then((response) => {
      employees.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/employee", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      employees.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

watch(
  searchQuery,
  debounce(() => {
    search();
  }, 300)
);

const deleteEmployee = (id) => {
  deleteEmployees()
    .then((result) => {
      if (result.isConfirmed) {
        return axios.delete(`/employee/${id}`);
      }
      throw new Error("Deletion not confirmed.");
    })
    .then(() => {
      employees.value.data = employees.value.data.filter(
        (employee) => employee.id !== id
      );
      Swal.fire("Deleted!", "Employee has been deleted.", "success");
    })
    .catch((error) => {
      console.error("Error deleting Employee:", error);
    });
};

onMounted(() => {
  getEmployee();

  setTimeout(() => {
    if (employees.value.data.length === 0) {
      showImage.value = true;
    }
  }, 100);
});
</script>


