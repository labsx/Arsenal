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
                    <div class="form-group">
                      <label for="title">Label</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.label"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter label"
                        :class="{ 'is-invalid': errors.label }"
                      />
                      <span
                        v-if="errors && errors.label"
                        class="text-danger text-sm"
                        >{{ errors.label[0] }}</span
                      >
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea
                    v-model="form.description"
                    class="form-control"
                    id="description"
                    rows="3"
                    placeholder="Enter Description"
                  ></textarea>
                </div>
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

const { errors, form, saveField } = editFields();
</script>