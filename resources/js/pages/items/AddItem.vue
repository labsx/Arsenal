<template>
  <ContentHeader title="Add Item" data="item" datas="add" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form form @submit.prevent="createItem">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="client">Select category</label>
                    <span class="text-danger"> *</span>
                    <select
                      id="fieldGroup"
                      class="form-control"
                      v-model="form.parent_id"
                      @change="getFields"
                      :class="{ 'is-invalid': errors.parent_id }"
                    >
                      <optgroup
                        v-for="categoryGroup in categoryGroups"
                        :key="categoryGroup.id"
                        :label="categoryGroup.name"
                      >
                        <option
                          value=""
                          disabled
                          selected
                          hidden
                          class="text-center"
                        >
                          Choose Category
                        </option>
                        <option
                          v-for="category in filteredSamples(categoryGroup.id)"
                          :key="category.id"
                          :value="category.id"
                        >
                          {{ category.name }}
                        </option>
                      </optgroup>
                    </select>
                    <span
                      v-if="errors && errors.parent_id"
                      class="text-danger text-sm"
                      >{{ errors.parent_id[0] }}</span
                    >
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <TextInput label="Item Name" :model="form.name" :error="errors.name ? errors.name[0] : null" @update:model="form.name = $event" 
                        type="text" placeholder="Enter item name"
                      />
                  </div>

                  <div class="col-md-3">
                     <StatusDropdown v-bind:value="form.status" @update:value="form.status = $event" v-bind:error="errors.status ? errors.status[0] : null" />
                  </div>
                  <div class="col-md-3">
                    <TextInput label="Serial" :model="form.serial" :error="errors.serial ? errors.serial[0] : null" @update:model="form.serial = $event" 
                        type="text" placeholder="Enter item serial"
                      />
                  </div>
                  <div class="col-md-3">
                      <TextInput label="Model" :model="form.model" :error="errors.model ? errors.model[0] : null" @update:model="form.model = $event" 
                        type="text" placeholder="Enter item name"
                      />
                  </div>
                  <div class="col-md-3">
                     <TextInput label="Manufacture Date" :model="form.mfg_date" :error="errors.mfg_date ? errors.mfg_date[0] : null" @update:model="form.mfg_date = $event" 
                        type="date" placeholder="Enter manufaturing date" :showAsterisk ="false"
                      />
                  </div>

                  <div class="col-md-3">
                     <TextInput label="Manufacturer" :model="form.manufacturer" :error="errors.manufacturer ? errors.manufacturer[0] : null" @update:model="form.manufacturer = $event" 
                        type="text" placeholder="Enter manufacturer " :showAsterisk ="false"
                      />
                  </div>

                  <div class="col-md-3">
                     <TextInput label="Manufacturer address" :model="form.location" :error="errors.location ? errors.location[0] : null" @update:model="form.location = $event" 
                        type="text" placeholder="Enter manufaturer location" :showAsterisk ="false"
                      />
                  </div>

                  <div class="col-md-3">
                     <TextInput label="Unit Price" :model="form.price" :error="errors.price ? errors.price[0] : null" @update:model="form.price = $event" 
                        type="text" placeholder="Enter item unit price" :showAsterisk ="false"
                      />
                  </div>
                  <div class="col-md-3">
                    <TextInput label="Warranty" :model="form.warranty" :error="errors.warranty ? errors.warranty[0] : null" @update:model="form.warranty = $event" 
                        type="text" placeholder="Enter item item warranty" :showAsterisk ="false" :smallText = "true" smallMessage = "enter days/months/year"
                      />
                  </div>
                  <div class="col-md-3">
                    <TextInput label="Net Weight" :model="form.net_weight" :error="errors.net_weight ? errors.net_weight[0] : null" @update:model="form.net_weight = $event" 
                        type="text" placeholder="Enter item weight" :showAsterisk ="false" :smallText = "true" smallMessage = "enter only number in kg"
                      />
                  </div>
                  <div class="col-md-3">
                    <TextInput label="Insurance" :model="form.insurance" :error="errors.insurance ? errors.insurance[0] : null" @update:model="form.insurance = $event" 
                        type="text" placeholder="Enter item insurance" :showAsterisk ="false"
                      />
                  </div>
                </div>

                <div class="row" v-if="form.parent_id">
                  <div
                    class="col-md-3"
                    v-for="(field, index) in fieldsData"
                    :key="index"
                  >
                    <div class="form-group">
                      <label class="d-flex align-items-center" for="time">
                        {{ field.label }}
                        <span
                          class="text-danger ml-1"
                          v-if="field.is_required === 'required'"
                          >*</span
                        >
                        <small
                          v-if="field.description"
                          class="form-text text-muted ml-2"
                          >( {{ field.description }} )</small
                        >
                      </label>

                      <input
                        v-model="form.fields[field.label]"
                        type="text"
                        class="form-control"
                        id="time"
                      />
                    </div>
                  </div>
                </div>

                <div class="row"></div>
                <button
                  v-if="form.parent_id"
                  type="submit"
                  class="btn btn-outline-primary btn-sm"
                >
                  <i class="fa fa-save mr-2"></i>Save
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
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { addItem } from "../../store/itemjs/additem.js";
import TextInput from "../../pages/layout/TextInput.vue";
import Dropdown from "../../pages/layout/Dropdown.vue";
import StatusDropdown from "../../pages/layout/StatusDropdown.vue";

const {
  errors,
  form,
  fieldsData,
  getFields,
  subcategories,
  createItem,
  getSubCategory,
  getCategory,
  categories,
  categoryGroups,
  filteredSamples,
} = addItem();
</script>
