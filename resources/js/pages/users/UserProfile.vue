<template>
  <ContentHeader
    title="Profile information"
    data="profile"
    datas="information"
  />
  <div class="content mt-5">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile" style="height: 255px">
              <div class="text-center">
                <input
                  @change="handleFileChange"
                  ref="fileInput"
                  type="file"
                  class="d-none"
                />
                <img
                  @click="openFileInput"
                  class="profile-user-img img-circle"
                  :src="authuserStore.user.avatar"
                  alt="User profile picture"
                    style="height: 150px; width: 150px "
                />
              </div>

              <h3 class="profile-username text-center mt-4">
                {{ authuserStore.user.name }}
              </h3>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link active" href="#profile" data-toggle="tab"
                    ><i class="fa fa-user mr-1"></i> Edit Profile</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#changePassword" data-toggle="tab"
                    ><i class="fa fa-key mr-1"></i> Change Password</a
                  >
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                  <form
                    @submit.prevent="updateProfile()"
                    class="form-horizontal"
                  >
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label"
                        >Name</label
                      >
                      <div class="col-sm-10">
                        <input
                          v-model="authuserStore.user.name"
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
                          v-model="authuserStore.user.email"
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
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-success">
                          <i class="fa fa-save mr-1"></i> Save Changes
                        </button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="tab-pane" id="changePassword">
                  <form
                    @submit.prevent="handleChangePassword()"
                    class="form-horizontal"
                  >
                    <div class="form-group row">
                      <label
                        for="currentPassword"
                        class="col-sm-3 col-form-label"
                        >Current Password</label
                      >
                      <div class="col-sm-9">
                        <input
                          v-model="changePasswordForm.currentPassword"
                          type="password"
                          class="form-control"
                          id="currentPassword"
                          placeholder="Current Password"
                          :style="{
                            borderColor: changePasswordForm.currentPassword
                              ? 'green'
                              : '',
                          }"
                        />
                        <span
                          v-if="errors && errors.current_password"
                          class="text-danger text-sm"
                          >{{ errors.current_password[0] }}</span
                        >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="newPassword" class="col-sm-3 col-form-label"
                        >New Password</label
                      >
                      <div class="col-sm-9">
                        <input
                          v-model="changePasswordForm.password"
                          type="password"
                          class="form-control"
                          id="newPassword"
                          placeholder="New Password"
                        />
                        <span
                          v-if="errors && errors.password"
                          class="text-danger text-sm"
                          >{{ errors.password[0] }}</span
                        >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="passwordConfirmation"
                        class="col-sm-3 col-form-label"
                        >Confirm New Password</label
                      >
                      <div class="col-sm-9">
                        <input
                          v-model="changePasswordForm.passwordConfirmation"
                          type="password"
                          class="form-control"
                          id="passwordConfirmation"
                          placeholder="Confirm New Password"
                         
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-3 col-sm-9">
                        <button type="submit" class="btn btn-success">
                          <i class="fa fa-save mr-1"></i> Save Changes
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
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { userProfile } from "../../store/users/userprofile.js";

const {
  updateProfile,
  fileInput,
  openFileInput,
  handleFileChange,
  handleChangePassword,
  authuserStore,
  errors,
  changePasswordForm,
} = userProfile();
</script>
<style scoped>
.profile-user-img:hover {
  background-color: blue;
  cursor: pointer;
}
</style>
