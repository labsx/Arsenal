<template>
  <ContentHeader title="Edit Fields" data="fields" datas="edit" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-md-12">
                     <TextInput label="Label" :model="form.label" :error="errors.label ? errors.label[0] : null" @update:model="form.label = $event" 
                        type="text" placeholder="Enter label name"
                     />
                  </div>
                </div>
                    <TextAreaInput label="Description" :model="form.description" :error="errors && errors.description ? errors.description[0] : null"
                      @update:model="form.description = $event"
                      />
                <div class="form-group">
                  <input
                    v-model="form.is_required"
                    type="checkbox"
                    style="width: 15px; height: 15px"
                    :checked="form.is_required === 'required'"
                  />
                  <label class="ml-2">required</label>
                </div>

                <button
                  @click.prevent="saveField"
                  type="submit"
                  class="btn btn-outline-primary"
                >
                  <i class="fa fa-save mr-1"></i>
                  Save changes
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import ContentHeader from "../../../pages/layout/ContentHeader.vue";
import { editFields } from "../../../store/fields/editfield.js";
import TextInput from "../../../pages/layout/TextInput.vue";
import TextAreaInput from "../../../pages/layout/TextAreaInput.vue";

const { errors, form, saveField } = editFields();
</script>