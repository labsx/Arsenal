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
        <div class="modal-header">
          <h5 class="modal-title" id="createUsers">Create user information</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
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
                              <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                id="title"
                                placeholder="Enter full name"
                                :class="{ 'is-invalid': errors.name }"
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
                              <input
                                v-model="form.email"
                                type="email"
                                class="form-control"
                                id="title"
                                placeholder="Enter email address"
                                :class="{ 'is-invalid': errors.email }"
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
                                <input
                                  v-model="form.password"
                                  type="text"
                                  class="form-control"
                                  id="title"
                                  placeholder="Enter user password "
                                  :class="{ 'is-invalid': errors.password }"
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
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-outline-secondary btn-sm"
            data-dismiss="modal"
          >
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button
            @click.prevent="creatUser()"
            type="submit"
            class="btn btn-outline-primary btn-sm"
          >
            <i class="fa fa-save mr-2"></i>Save Item
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { addUser } from "../../store/users/userform.js";
import { defineProps } from "vue";

const { getUsersFn } = defineProps(["getUsersFn"]);
const { errors, form, creatUser } = addUser(getUsersFn);
</script>
