<template>
  <ContentHeader title="" data="category" datas="edit" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Update Category</h3>
            </div>
            <form>
              <div class="card-body">
                <div class="form-group">
                  <label for="appName">Category Name</label>
                  <span class="text-danger"> *</span>
                  <input
                    v-model="form.name"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter category name"
                    :class="{ 'is-invalid': errors.name }"
                    :style="{ borderColor: form.name ? 'green' : '' }"
                  />
                  <span
                    v-if="errors && errors.name"
                    class="text-danger text-sm"
                    >{{ errors.name[0] }}</span
                  >
                </div>

                <div class="form-group" v-if="form.parent_id">
                  <div class="form-group">
                    <label for="client">Parent Category</label>
                    <span class="text-danger"> *</span>
                    <select
                      id="client"
                      class="form-control"
                      v-model="form.parent_id"
                      name="parent_id"
                      :style="{ borderColor: form.parent_id ? 'green' : '' }"
                    >
                      <option value="" disabled selected hidden>
                        Select Parent
                      </option>
                      <option
                        v-for="category in filterCategory"
                        :key="category.id"
                        :value="category.id"
                      >
                        {{ category.name }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="form-group" v-if="form.parent_id">
                  <label for="dateFormat">Group Fields</label>
                  <span class="text-danger"> *</span>
                  <select
                    class="form-control"
                    v-model="form.field_group_id"
                    :style="{ borderColor: form.field_group_id ? 'green' : '' }"
                  >
                    <option
                      :value="field.id"
                      v-for="field in field_groups"
                      :key="field.id"
                    >
                      {{ field.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="saveCategory"
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
import { editCategory } from "../../store/categoryjs/editcategory.js";

const {
  errors,
  form,
  field_groups,
  getFieldGroup,
  ItemDetails,
  saveCategory,
  categories,
  filterCategory,
} = editCategory();
</script>
