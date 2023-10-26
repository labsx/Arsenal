<template>
  <div
    class="modal fade"
    id="createCategory"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createCategory"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <Header header="Add Category" />
        <div class="modal-body">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form @submit.prevent="createItem()">
                        <div class="row">
                          <TextInput label="Category Name" :model="form.name" :error="errors.name ? errors.name[0] : null" @update:model="form.name = $event" 
                              type="text" placeholder="Enter category name"
                          />
                        </div>
                        <Dropdown label="Parent Category" placeholder="Select Parent" :items="filterCategory" :model="form.parent_id"  :updateModel="value => form.parent_id = value" />
                        <Dropdown label="Fields Group" placeholder="Select Field Groups" :items="field_groups" :model="form.field_groups_id" :updateModel="value => form.field_groups_id = value" />
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
import { defineProps } from "vue";
import { addCategory } from "../../store/categoryjs/categoryadd.js";
import Header from "../../pages/layout/Modal-header.vue";
import ModalFooter from "../../pages/layout/ModalFooter.vue";
import TextInput from "../../pages/layout/TextInput.vue";
import Dropdown from "../../pages/layout/Dropdown.vue";

const { getCategoryFn } = defineProps(["getCategoryFn"]);
const {
  errors,
  form,
  categories,
  filterCategory,
  getCategory,
  getFieldGroup,
  field_groups,
  dataTosave,
} = addCategory(getCategoryFn);
</script>
