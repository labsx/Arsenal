<template>
  <ContentHeader title="Edit Field Groups" data="item" datas="edit" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Field Groups</h3>
            </div>

            <form>
              <div class="card-body">
                <div class="form-group">
                  <label for="appName">Field Name</label>
                  <span class="text-danger"> *</span>
                  <input
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder=""
                    :class="{ 'is-invalid': errors.name }"
                  />
                  <span
                    v-if="errors && errors.name"
                    class="text-danger text-sm"
                    >{{ errors.name[0] }}</span
                  >
                </div>
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea
                    v-model="form.description"
                    type="text"
                    class="form-control"
                  ></textarea>
                </div>
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="saveGroupFields"
                  type="submit"
                  class="btn btn-primary"
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
import { editFieldGroups } from "../../store/field-groups/field-groups.js";

const { form, errors, saveGroupFields } = editFieldGroups();
</script>