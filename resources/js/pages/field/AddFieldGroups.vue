<template>
  <div
    class="modal fade"
    id="createFieldsGroup"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createFieldsGroup"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document" style="max-width: 40%">
      <div class="modal-content">
        <Header header="Add field groups" />
        <div class="modal-body">
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <form>
                        <div class="row">
                          <div class="col-md-6"></div>
                        </div>
                        <div class="row">
                            <TextInput label="Field group name" :model="form.name" :error="errors.name ? errors.name[0] : null" @update:model="form.name = $event" 
                                  type="text" placeholder="Enter first name"
                              />
                        </div>
                            <TextAreaInput label="Description" :model="form.description" :error="errors && errors.description ? errors.description[0] : null"
                                  @update:model="form.description = $event"
                            />
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
import addFieldGroups from "../../store/field-groups/addfield-groups.js";
import Header from "../../pages/layout/Modal-header.vue";
import ModalFooter from "../../pages/layout/ModalFooter.vue";
import TextInput from "../../pages/layout/TextInput.vue";
import TextAreaInput from "../../pages/layout/TextAreaInput.vue";

const { errors, form, dataTosave } = addFieldGroups(getFieldsGroupsFn);
const { getFieldsGroupsFn } = defineProps(["getFieldsGroupsFn"]);
</script>
