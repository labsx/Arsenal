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
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="title">First Name</label>
                              <span class="text-danger"> *</span>
                              <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                id="title"
                                placeholder="Enter full name"
                                :class="{ 'is-invalid': errors.name }"
                                :style="{
                                  borderColor: form.name ? 'green' : '',
                                }"
                              />
                              <span
                                v-if="errors && errors.name"
                                class="text-danger text-sm"
                                >{{ errors.name[0] }}</span
                              >
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="title">Email</label>
                              <span class="text-danger"> *</span>
                              <input
                                v-model="form.email"
                                type="email"
                                class="form-control"
                                id="title"
                                placeholder="Enter email address"
                                :class="{ 'is-invalid': errors.email }"
                                :style="{
                                  borderColor: form.email ? 'green' : '',
                                }"
                              />
                              <span
                                v-if="errors && errors.email"
                                class="text-danger text-sm"
                                >{{ errors.email[0] }}</span
                              >
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="title">Password</label>
                                <span class="text-danger"> *</span>
                                <input
                                  v-model="form.password"
                                  type="text"
                                  class="form-control"
                                  id="title"
                                  placeholder="Enter user password "
                                  :class="{ 'is-invalid': errors.password }"
                                  :style="{
                                    borderColor: form.password ? 'green' : '',
                                  }"
                                />
                                <span
                                  v-if="errors && errors.password"
                                  class="text-danger text-sm"
                                  >{{ errors.password[0] }}</span
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
import { addUser } from "../../store/users/userform.js";
import { defineProps } from "vue";
import Header from "./../../pages/layout/Modal-header.vue";
import ModalFooter from "./../../pages/layout/ModalFooter.vue";

const { getUsersFn } = defineProps(["getUsersFn"]);
const { errors, form, dataTosave } = addUser(getUsersFn);
</script>
