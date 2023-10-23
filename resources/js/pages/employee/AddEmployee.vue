<template>
  <div
    class="modal fade"
    id="addEmployee"
    tabindex="-1"
    role="dialog"
    aria-labelledby="addEmployee"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <Header header="Add Employee" />
        <div class="modal-body">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form @submit.prevent="createEmployee()">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="title">First Name</label>
                              <span class="text-danger"> *</span>
                              <input
                                v-model="form.first_name"
                                type="text"
                                class="form-control"
                                id="title"
                                placeholder="Enter first name"
                                :class="{ 'is-invalid': errors.first_name }"
                              />
                              <span
                                v-if="errors && errors.first_name"
                                class="text-danger text-sm"
                                >{{ errors.first_name[0] }}</span
                              >
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="title">Last Name</label>
                              <span class="text-danger"> *</span>
                              <input
                                v-model="form.last_name"
                                type="text"
                                class="form-control"
                                id="title"
                                placeholder="Enter last name"
                                :class="{ 'is-invalid': errors.last_name }"
                              />
                              <span
                                v-if="errors && errors.last_name"
                                class="text-danger text-sm"
                                >{{ errors.last_name[0] }}</span
                              >
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="title">Position</label>
                                <span class="text-danger"> *</span>
                                <input
                                  v-model="form.position"
                                  type="text"
                                  class="form-control"
                                  id="title"
                                  placeholder="Enter position "
                                  :class="{ 'is-invalid': errors.position }"
                                />
                                <span
                                  v-if="errors && errors.position"
                                  class="text-danger text-sm"
                                  >{{ errors.position[0] }}</span
                                >
                              </div>
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
        <ModalFooter :dataTosave="dataTosave" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from "vue";
import addEmployee from "../../store/employeejs/add-employee.js";
import Header from "../../pages/layout/Modal-header.vue";
import ModalFooter from "../../pages/layout/ModalFooter.vue";

const { getEmployeeFn } = defineProps(["getEmployeeFn"]);
const { errors, form, dataTosave } = addEmployee(getEmployeeFn);
//import AddEmployee from '../employee/AddEmployee.js';

// export default {
//   mixins: [AddEmployee],
// };
</script>
