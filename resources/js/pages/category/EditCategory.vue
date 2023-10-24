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
                 <TextInput label="Category Name" :model="form.name" :error="errors.name ? errors.name[0] : null" @update:model="form.name = $event" 
                    type="text" placeholder="Enter first name"
                  />
                  <Dropdown v-if="form.parent_id" label="Parent Category" placeholder="Select Parent" :items="filterCategory" 
                    :model="form.parent_id"  :updateModel="value => form.parent_id = value" 
                  />
                   <Dropdown v-if="form.parent_id" label="Fields Group" placeholder="Select Field Groups" :items="field_groups" 
                    :model="form.field_group_id" :updateModel="value => form.field_group_id = value" 
                   />
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
import TextInput from "../../pages/layout/TextInput.vue";
import Dropdown from "../../pages/layout/Dropdown.vue";

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
