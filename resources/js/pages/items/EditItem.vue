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
                    <div class="form-group">
                      <label for="title">Item Name</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.name"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter Title"
                        :class="{ 'is-invalid': errors.name }"
                      />
                      <span
                        v-if="errors && errors.name"
                        class="text-danger text-sm"
                        >{{ errors.name[0] }}</span
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
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="date">Serial</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.serial"
                        type="text"
                        class="form-control"
                        id="date"
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
                      <label for="date">Model</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.model"
                        type="text"
                        class="form-control"
                        id="date"
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
                      <label for="date">Mfg. Date</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.mfg_date"
                        type="date"
                        class="form-control"
                        id="date"
                        :class="{ 'is-invalid': errors.mfg_date }"
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
                      <label for="date">Manufacturer</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.manufacturer"
                        type="text"
                        class="form-control"
                        id="date"
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
                      <label for="date">Manufacturer address</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.location"
                        type="text"
                        class="form-control"
                        id="date"
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
                      <label for="date">Unit Price</label>
                      <span class="text-danger"> *</span>
                      <input
                        v-model="form.price"
                        type="integer"
                        class="form-control"
                        id="date"
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
                      <label for="date">Warranty</label>
                      <input
                        v-model="form.warranty"
                        type="text"
                        class="form-control"
                        id="date"
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
                        id="text"
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
                      <label for="date">Insurance</label>
                      <input
                        v-model="form.insurance"
                        type="text"
                        class="form-control"
                        id="date"
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

