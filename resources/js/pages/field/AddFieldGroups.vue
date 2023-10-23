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
        <div class="modal-header">
          <h5 class="modal-title" id="createFieldsGroup">Field Groups</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
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
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="title">Field Name</label>
                              <span class="text-danger"> *</span>
                              <input
                                type="text"
                                class="form-control"
                                id="title"
                                placeholder="Enter field groups name"
                                v-model="form.name"
                                :class="{ 'is-invalid': errors.name }"
                              />
                              <span
                                v-if="errors && errors.name"
                                class="text-danger text-sm"
                                >{{ errors.name[0] }}</span
                              >
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea
                            class="form-control"
                            rows="3"
                            placeholder="Enter field groups description"
                            v-model="form.description"
                          ></textarea>
                          <span
                            v-if="errors && errors.description"
                            class="text-danger text-sm"
                            >{{ errors.description[0] }}</span
                          >
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-outline-secondary btn-sm"
            data-dismiss="modal"
          >
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button
            @click="createFields()"
            type="submit"
            class="btn btn-outline-primary btn-sm"
          >
            <i class="fa fa-save mr-2"></i>Save Item
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from "vue";
import addFieldGroups from "../../store/field-groups/addfield-groups.js";

const { errors, form, createFields } = addFieldGroups(getFieldsGroupsFn);
const { getFieldsGroupsFn } = defineProps(["getFieldsGroupsFn"]);
</script>
