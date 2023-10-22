<template>
<ContentHeader title="Fields" data="field groups" datas="data"/>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <button
                class="btn btn-outline-primary ml-1 btn-sm"
                data-toggle="modal"
                data-target="#createFieldData"
              >
                <i class="fa fa-plus-circle mr-1"></i>ADD FIELDS
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
                <thead>
                  <tr v-if="fields.data.length > 0">
                    <th scope="col">Label</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody v-if="fields.data.length > 0">
                  <tr v-for="field in fields.data" :key="field.id">
                    <td>{{ field.label }}</td>
                    <td>{{ field.description }}</td>
                    <td>{{ field.is_required }}</td>
                    <td>
                      <router-link :to="`/admin/edit/${field.id}/fields`">
                        <i class="fas fa-edit"></i>
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
                        v-if="showImage && fields.data.length === 0"
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
              :data="fields"
              @pagination-change-page="getFieldsById"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <AddFieldsData :getFieldByIdFn="getFieldsById" />
</template>

<script setup>
import { fieldDetails } from "../../../store/fields/fields.js";
 import { Bootstrap4Pagination } from "laravel-vue-pagination";
 import AddFieldsData from "./AddFieldsData.vue";
 import imagePath from "/resources/image/no data.gif";
 import ContentHeader from "../../../pages/layout/ContentHeader.vue";

 const { showImage, toastr, route, fields, getFieldsById, deleteFields, searchQuery, search } = fieldDetails();
</script>