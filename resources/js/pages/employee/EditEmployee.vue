<template>
  <ContentHeader title="" data="employees" datas="edit" />
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

              <div class="card-footer">
                <button
                  @click.prevent="saveEmployee"
                  type="submit"
                  class="btn btn-outline-primary"
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
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { updateEmployee } from "../../store/employeejs/edit-employee.js";
import TextInput from "../../pages/layout/TextInput.vue";

const { form, errors, saveEmployee } = updateEmployee();
</script>

