<template>
  <ContentHeader title="Field Groups" data="item" datas="field groups" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <button
                class="btn btn-outline-primary ml-1 btn-sm"
                data-toggle="modal"
                data-target="#createFieldsGroup"
              >
                <i class="fa fa-plus-circle mr-1"></i>ADD FIELD GROUPS
              </button>
            </div>
            <div>
              <div class="input-group">
                <input
                  v-model="searchQuery"
                  type="text"
                  class="form-control"
                  placeholder="Search..."
                />
                <div class="input-group-append">
                  <span class="input-group-text"
                    ><i class="fa fa-search text-primary" aria-hidden="true"></i
                  ></span>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table align-middle">
                <thead v-if="field_groups.data.length > 0">
                  <tr>
                    <th scope="col">Field Groups Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="field_groups.data.length > 0">
                  <tr v-for="field in field_groups.data" :key="field.id">
                    <td>{{ field.name }}</td>
                    <td>{{ field.description || 'no description added' }}</td>

                    <td>
                      <router-link :to="`/admin/fields/${field.id}/add`">
                        <i class="fas fa-eye"></i>
                      </router-link>

                      <router-link :to="`/admin/edit/${field.id}/field_groups`">
                        <i class="fas fa-edit ml-2"></i>
                      </router-link>

                      <router-link
                        to=""
                        @click.prevent="deleteFields(field.id)"
                      >
                        <i class="fa fa-trash text-danger ml-2"></i>
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="8" style="text-align: center">
                      <img
                        v-if="showImage && field_groups.data.length === 0"
                        :src="imagePath"
                        alt="No Data Found"
                        style="max-width: 750px; height: auto"
                      />
                      <p style="font-weight: bold; color: red">
                        No data found !
                      </p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div>
            <Bootstrap4Pagination
              :data="field_groups"
              @pagination-change-page="getFieldsGroups"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <AddFieldGroups :getFieldsGroupsFn="getFieldsGroups" />
</template>
<script setup>
import axios from "axios";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import AddFieldGroups from "./AddFieldGroups.vue";
import imagePath from "/resources/image/no data.gif";
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { fieldGroupDetails } from "../../store/field-groups/field-groups.js";

const { showImage, field_groups, searchQuery, getFieldsGroups, deleteFields } =
  fieldGroupDetails();
</script>