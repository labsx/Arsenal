<template>
  <ContentHeader title="Edit Item" data="item" datas="edit" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="row">
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
                            v-for="category in filteredSamples(
                              categoryGroup.id
                            )"
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
                </div>
  
                <div class="row">
                  <div class="col-md-6">
                    <TextInput label="Item Name" :model="form.name" :error="errors.name ? errors.name[0] : null" @update:model="form.name = $event" 
                        type="text" placeholder="Enter item name"
                      />
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
                    </div>
                  <!-- <StatusDropdown v-bind:value="form.status" @update:value="form.status = $event" v-bind:error="errors.status ? errors.status[0] : null" /> -->
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
                        type="date" placeholder="" :showAsterisk ="false"
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
                
                <h4>Attributes:</h4>

                <div
                  v-for="(attribute, index) in form.value"
                  :key="index"
                  class="attribute"
                >
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Name</label>
                        <input
                          v-model="attribute.name"
                          :name="`value[${index}][label]`"
                          type="text"
                          class="form-control"
                          id="title"
                          placeholder=""
                          :class="{ 'is-invalid': attribute.name === '' }"
                        />
                      </div>
                    </div>

                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="date">Value</label>
                        <input
                          type="text"
                          class="form-control"
                          id="date"
                          v-model="attribute.value"
                          :name="`value[${index}][value]`"
                          :class="{ 'is-invalid': attribute.value === '' }"
                        />
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="form-group">
                        <i
                          class="fa fa-times mt-4 text-danger"
                          @click="removeAttribute(index)"
                          style="cursor: pointer"
                        ></i>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="text-center">
                  <button
                    type="button"
                    class="btn btn-outline-info"
                    @click="addAttribute"
                  >
                    <i class="fa fa-plus"></i>
                    Add Attribute
                  </button>
                </div>

                <button
                  @click.prevent="handleSubmit()"
                  type="submit"
                  class="btn btn-outline-primary"
                >
                  <i class="fa fa-save mr-2"></i>
                  Save Changes
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
import { editItems } from "../../store/itemjs/edititem.js";
import StatusDropdown from "../../pages/layout/StatusDropdown.vue";
import TextInput from "../../pages/layout/TextInput.vue";

const {
  errors,
  form,
  handleSubmit,
  addAttribute,
  removeAttribute,
  getAttributes,
  categories,
  categoryGroups,
  filteredSamples,
} = editItems();

</script>

