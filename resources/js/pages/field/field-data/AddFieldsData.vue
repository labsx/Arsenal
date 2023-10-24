<template>
  <div
    class="modal fade"
    id="createFieldData"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createFieldData"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <Header :header="`Add fields for ${form.name}`" />
        <div class="modal-body">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form>
                        <div class="row">
                          <TextInput :model="form.field_groups_id"  @update:model="form.field_groups_id = $event"  type="text"  style="display: none"/>
                          <TextInput label="Label" :model="form.label" :error="errors.label ? errors.label[0] : null" @update:model="form.label = $event" 
                                type="text" placeholder="Enter label name"
                          />
                          <div class="form-group col-md-12">
                             <TextAreaInput label="Description" :model="form.description" :error="errors && errors.description ? errors.description[0] : null"
                                  @update:model="form.description = $event"
                            />
                          </div>
                          <div class="form-group ml-2">
                            <input v-model="form.is_required" type="checkbox" />
                            <label class="ml-2">required</label>
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
import { defineProps } from "vue";
import { addField } from "../../../store/fields/addfield.js";
import Header from "../../../pages/layout/Modal-header.vue";
import ModalFooter from "../../../pages/layout/ModalFooter.vue";
import TextInput from "../../../pages/layout/TextInput.vue";
import TextAreaInput from "../../../pages/layout/TextAreaInput.vue";

const { errors, form, dataTosave } = addField(getFieldByIdFn);
const { getFieldByIdFn } = defineProps(["getFieldByIdFn"]);
</script>
