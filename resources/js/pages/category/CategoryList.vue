<template>
  <ContentHeader title="Category List" data="category" datas="list" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <ModalButtonAdd :modalTarget="'#createCategory'" :title="'New Category'" />
            <Search v-model="searchQuery" /> 
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table align-middle">
                <thead v-if="categories.data.length > 0">
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Parent</th>
                    <th scope="col">Fields</th>
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="categories.data.length > 0">
                  <tr v-for="category in categories.data" :key="category.id">
                    <td>{{ category.name }}</td>
                    <td>
                      <span v-if="category.parent_name === null"
                        >Main Category</span
                      >
                      <span v-else>{{ category.parent_name }}</span>
                    </td>
                    <td>{{ category.field_group_name }}</td>
                    <td>
                      <router-link :to="`/admin/category/${category.id}/edit`">
                        <i class="fas fa-edit"></i>
                      </router-link>

                      <router-link
                        to=""
                        @click.prevent="deleteCategory(category.id)"
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
          <div class="float-right">
            <Bootstrap4Pagination
              :data="categories"
              @pagination-change-page="getCategory"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <CategoryAdd :getCategoryFn="getCategory" />
</template>

<script setup>
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import imagePath from "/resources/image/no data.gif";
import flatpickr from "flatpickr";
import CategoryAdd from "./CategoryAdd.vue";
import { formatDate } from "../../helper.js";
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import Search from "../../pages/layout/Search.vue";
import { categoryDetails } from "../../store/categoryjs/categorydetails.js";
import TableNoData from "../../pages/layout/TableNoData.vue";
import ModalButtonAdd from "../../pages/layout/ModalButtonAdd.vue";

const {
  errors,
  getCategory,
  showImage,
  categories,
  deleteCategory,
  searchQuery,
  getParentCategoryName,
  getFieldGroupName,
} = categoryDetails();
</script>


