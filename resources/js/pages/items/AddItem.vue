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
                    <div class="form-group">
                      <label for="title">Item Name</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.item_name"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item name"
                        :class="{ 'is-invalid': errors.item_name }"
                      />
                      <span
                        v-if="errors && errors.item_name"
                        class="text-danger text-sm"
                        >{{ errors.item_name[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="client">Status</label>
                      <span class="text-danger"> *</span>
                      <select
                        v-model="form.status"
                        id="client"
                        class="form-control"
                        :class="{ 'is-invalid': errors.status }"
                      >
                        <option value="" disabled selected hidden>
                          Select Status
                        </option>
                        <option value="operating">Operating</option>
                        <option value="decommissioned">Decommissioned</option>
                        <option value="under repair">Under Repair</option>
                      </select>
                      <span
                        v-if="errors && errors.status"
                        class="text-danger text-sm"
                        >{{ errors.status[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="serial">Serial</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.serial"
                        type="text"
                        class="form-control"
                        id="serial"
                        placeholder="Enter item serial number"
                        :class="{ 'is-invalid': errors.serial }"
                      />
                      <span
                        v-if="errors && errors.serial"
                        class="text-danger text-sm"
                        >{{ errors.serial[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="title">Model</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.model"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter item model number"
                        :class="{ 'is-invalid': errors.model }"
                      />
                      <span
                        v-if="errors && errors.model"
                        class="text-danger text-sm"
                        >{{ errors.model[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="title">Mfg Date</label>
                      <input
                        v-model="form.mfg_date"
                        type="date"
                        class="form-control flatpickr"
                        id="title"
                        placeholder="Select manufacturing date"
                        :class="{ 'is-invalid': errors.mfg_date }"
                        style="background: white"
                      />
                      <span
                        v-if="errors && errors.mfg_date"
                        class="text-danger text-sm"
                        >{{ errors.mfg_date[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="price">Manufacturer</label>
                      <input
                        v-model="form.manufacturer"
                        type="text"
                        class="form-control"
                        id="Manufacturer"
                        placeholder="Enter item manufacturer"
                        :class="{ 'is-invalid': errors.manufacturer }"
                      />
                      <span
                        v-if="errors && errors.manufacturer"
                        class="text-danger text-sm"
                        >{{ errors.manufacturer[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="price">Manufacturer address</label>
                      <input
                        v-model="form.location"
                        type="text"
                        class="form-control"
                        id="location"
                        placeholder="Enter item manufacturer address"
                        :class="{ 'is-invalid': errors.location }"
                      />
                      <span
                        v-if="errors && errors.location"
                        class="text-danger text-sm"
                        >{{ errors.location[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="price">Unit price</label>
                      <input
                        v-model="form.price"
                        type="text"
                        class="form-control"
                        id="price"
                        placeholder="₱"
                        :class="{ 'is-invalid': errors.price }"
                      />
                      <span
                        v-if="errors && errors.price"
                        class="text-danger text-sm"
                        >{{ errors.price[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="d-flex align-items-center"
                        >Warranty
                        <small class="form-text text-muted ml-2"
                          >( enter days/months/year )</small
                        >
                      </label>
                      <input
                        v-model="form.warranty"
                        type="text"
                        class="form-control"
                        id="price"
                        placeholder="Enter item warranty"
                        :class="{ 'is-invalid': errors.warranty }"
                      />
                      <span
                        v-if="errors && errors.warranty"
                        class="text-danger text-sm"
                        >{{ errors.warranty[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="d-flex align-items-center"
                        >Net. Weight
                        <small class="form-text text-muted ml-2"
                          >( enter only number in kg )</small
                        >
                      </label>
                      <input
                        v-model="form.net_weight"
                        type="text"
                        class="form-control"
                        id="price"
                        placeholder="Enter item net weight in kg"
                        :class="{ 'is-invalid': errors.net_weight }"
                      />
                      <span
                        v-if="errors && errors.net_weight"
                        class="text-danger text-sm"
                        >{{ errors.net_weight[0] }}</span
                      >
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="price">Insurance</label>
                      <input
                        v-model="form.insurance"
                        type="text"
                        class="form-control"
                        id="insurance"
                        placeholder="Enter item insurance"
                        :class="{ 'is-invalid': errors.insurance }"
                      />
                      <span
                        v-if="errors && errors.insurance"
                        class="text-danger text-sm"
                        >{{ errors.insurance[0] }}</span
                      >
                    </div>
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
                <button v-if="form.parent_id" type="submit" class="btn btn-outline-primary btn-sm">
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
