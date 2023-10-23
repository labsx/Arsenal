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
            <Search v-model="searchQuery" />
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
                      <router-link :to="`/admin/employee/${employee.id}/edit`">
                        <i class="fas fa-edit"></i>
                      </router-link>

                      <router-link
                        to=""
                        @click.prevent="deleteEmployee(employee.id)"
                      >
                        <i class="fa fa-trash text-danger ml-2"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                 <TableNoData v-else :showImage="showImage" :imagePath="imagePath" />
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
import { employeeDetails } from "../../store/employeejs/employee-dashboard.js";
import AddEmployee from "./AddEmployee.vue";
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import imagePath from "/resources/image/no data.gif";
import Search from "../../pages/layout/Search.vue";
import TableNoData from "../../pages/layout/TableNoData.vue";

const {
  showImage,
  errors,
  employees,
  searchQuery,
  getEmployee,
  deleteEmployee,
} = employeeDetails();
</script>


