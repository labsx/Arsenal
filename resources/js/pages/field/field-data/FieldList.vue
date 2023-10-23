<template>
  <ContentHeader title="Fields" data="field groups" datas="data" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <ModalButtonAdd :modalTarget="'#createFieldData'" :title="'Add field'" />
            <Search v-model="searchQuery" />
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
                    <td>
                      {{ field.description || "no field description added " }}
                    </td>
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
                <TableNoData v-else :showImage="showImage" :imagePath="imagePath" />
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
import Search from "../../../pages/layout/Search.vue";
import TableNoData from "../../../pages/layout/TableNoData.vue";
import ModalButtonAdd from "../../../pages/layout/ModalButtonAdd.vue";

const {
  showImage,
  toastr,
  route,
  fields,
  getFieldsById,
  deleteFields,
  searchQuery,
  search,
} = fieldDetails();
</script>