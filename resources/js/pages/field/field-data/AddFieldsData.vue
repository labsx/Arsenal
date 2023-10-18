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
        <div class="modal-header">
          <h5 class="modal-title" id="createFieldData">{{ form.name }}</h5>
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
                          <div class="col-md-12">
                            <input
                              v-model="form.field_groups_id"
                              type="text"
                              name=""
                              id=""
                              style="display: none"
                            />
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="date">Label</label>
                              <span class="text-danger"> *</span>
                              <input
                                v-model="form.label"
                                type="text"
                                class="form-control"
                                id="text"
                                :class="{ 'is-invalid': errors.label }"
                              />
                              <span
                                v-if="errors && errors.label"
                                class="text-danger text-sm"
                                >{{ errors.label[0] }}</span
                              >
                            </div>
                          </div>

                          <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea
                              class="form-control"
                              id="description"
                              rows="3"
                              v-model="form.description"
                              placeholder="Enter Description"
                            ></textarea>
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
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-outline-secondary btn-sm"
            data-dismiss="modal"
          >
            <i class="fa fa-times mr-2 text-danger"></i>Close
          </button>
          <button
            @click.prevent="createField()"
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
import { addField } from "../../../store/fields/fields.js";

const { errors, form, createField } = addField(getFieldByIdFn);
const { getFieldByIdFn } = defineProps(["getFieldByIdFn"]);
</script>
