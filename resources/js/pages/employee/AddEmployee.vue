<template>
  <div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployee" aria-hidden="true">
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
                              <TextInput label="First Name" :model="form.first_name" :error="errors.first_name ? errors.first_name[0] : null" @update:model="form.first_name = $event" 
                                  type="text" placeholder="Enter first name"
                              />
                              <TextInput label="Last Name" :model="form.last_name" :error="errors.last_name ? errors.last_name[0] : null" @update:model="form.last_name = $event"
                                  type="text" placeholder="Enter last name"
                              />
                              <TextInput label="Position" :model="form.position" :error="errors.position ? errors.position[0] : null" @update:model="form.position = $event"
                                  type="text" placeholder="Enter position"
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
import TextInput from "../../pages/layout/TextInput.vue";

const { getEmployeeFn } = defineProps(["getEmployeeFn"]);
const { errors, form, dataTosave } = addEmployee(getEmployeeFn);
//import AddEmployee from '../employee/AddEmployee.js';

// export default {
//   mixins: [AddEmployee],
// };
</script>
