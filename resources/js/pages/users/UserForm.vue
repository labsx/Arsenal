<template>
  <div
    class="modal fade"
    id="createUsers"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createUsers"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <Header header="Add user information" />
        <div class="modal-body">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form @submit.prevent="createEmployee()">
                        <div class="row">
                              <TextInput label="Full Name" :model="form.name" :error="errors.name ? errors.name[0] : null" @update:model="form.name = $event" 
                                    type="text" placeholder="Enter full name"
                                />
                              <TextInput label="Email" :model="form.email" :error="errors.email ? errors.email[0] : null" @update:model="form.email = $event" 
                                    type="email" placeholder="Enter user email"
                                />
                                <TextInput label="Password" :model="form.password" :error="errors.password ? errors.password[0] : null" @update:model="form.password = $event" 
                                    type="password" placeholder="Enter user password"
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
import { addUser } from "../../store/users/userform.js";
import { defineProps } from "vue";
import Header from "./../../pages/layout/Modal-header.vue";
import ModalFooter from "./../../pages/layout/ModalFooter.vue";
import TextInput from "../../pages/layout/TextInput.vue";

const { getUsersFn } = defineProps(["getUsersFn"]);
const { errors, form, dataTosave } = addUser(getUsersFn);
</script>
