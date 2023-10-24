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
                 <TextInput label="Field group name" :model="form.name" :error="errors.name ? errors.name[0] : null" @update:model="form.name = $event" 
                    type="text" placeholder="Enter field group name"
                  />
                <TextAreaInput label="Description" :model="form.description" :error="errors && errors.description ? errors.description[0] : null"
                    @update:model="form.description = $event"
                />
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="saveGroupFields"
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
import { editFieldGroups } from "../../store/field-groups/editfield-groups.js";
import TextInput from "../../pages/layout/TextInput.vue";
import TextAreaInput from "../../pages/layout/TextAreaInput.vue";

const { form, errors, saveGroupFields } = editFieldGroups();
</script>