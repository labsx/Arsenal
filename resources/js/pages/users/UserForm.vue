<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link active" href="#profile" data-toggle="tab"
                    ><i class="fa fa-user mr-1"></i> Create Profile</a
                  >
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                  <form @submit.prevent="creatUser()" class="form-horizontal">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label"
                        >Name</label
                      >
                      <div class="col-sm-10">
                        <input
                          v-model="form.name"
                          type="text"
                          class="form-control"
                          id="inputName"
                          placeholder="Name"
                          :class="{ 'is-invalid': errors.name }"
                        />
                        <span
                          v-if="errors && errors.name"
                          class="text-danger text-sm"
                          >{{ errors.name[0] }}</span
                        >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label"
                        >Email</label
                      >
                      <div class="col-sm-10">
                        <input
                          v-model="form.email"
                          type="email"
                          class="form-control"
                          id="inputEmail"
                          placeholder="Email"
                          :class="{ 'is-invalid': errors.email }"
                        />
                        <span
                          v-if="errors && errors.email"
                          class="text-danger text-sm"
                          >{{ errors.email[0] }}</span
                        >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label"
                        >Password</label
                      >
                      <div class="col-sm-10">
                        <input
                          v-model="form.password"
                          type="password"
                          class="form-control"
                          id="inputEmail"
                          placeholder="Password"
                          :class="{ 'is-invalid': errors.password }"
                        />
                        <span
                          v-if="errors && errors.password"
                          class="text-danger text-sm"
                          >{{ errors.password[0] }}</span
                        >
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-outline-success">
                          <i class="fa fa-save mr-1"></i> Create User
                        </button>
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
  </div>
</template>
<script setup>
import { addUser } from "../../store/users/userform.js";

const { errors, form, creatUser} = addUser();
</script>

this is from UserForm.vue