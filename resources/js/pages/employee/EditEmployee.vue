<template>
  <ContentHeader data="employees" datas="edit" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Employee</h3>
            </div>

            <form>
              <div class="card-body">
                <div class="form-group">
                  <label for="appName">First Name</label>
                  <input
                    v-model="form.first_name"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter employee first name"
                    :class="{ 'is-invalid': errors.first_name }"
                  />
                  <span
                    v-if="errors && errors.first_name"
                    class="text-danger text-sm"
                    >{{ errors.first_name[0] }}</span
                  >
                </div>

                <div class="form-group">
                  <label for="appName">Last Name</label>
                  <input
                    v-model="form.last_name"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter employee last name"
                    :class="{ 'is-invalid': errors.last_name }"
                  />
                  <span
                    v-if="errors && errors.last_name"
                    class="text-danger text-sm"
                    >{{ errors.last_name[0] }}</span
                  >
                </div>

                <div class="form-group">
                  <label for="appName">Position</label>
                  <input
                    v-model="form.position"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter employee position"
                    :class="{ 'is-invalid': errors.position }"
                  />
                  <span
                    v-if="errors && errors.position"
                    class="text-danger text-sm"
                    >{{ errors.position[0] }}</span
                  >
                </div>
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="saveEmployee"
                  type="submit"
                  class="btn btn-outline-primary"
                >
                  <i class="fa fa-save mr-1"></i>Update Employee
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
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { updateEmployee } from "../../store/employeejs/employee.js";

const { form, errors, saveEmployee } = updateEmployee();
</script>

