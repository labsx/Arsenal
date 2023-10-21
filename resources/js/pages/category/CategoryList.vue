<template>
  <ContentHeader title="Category List" data="category" datas="list" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <button
                class="btn btn-outline-primary btn-sm"
                data-toggle="modal"
                data-target="#createCategory"
              >
                <i class="fa fa-plus-circle mr-1"></i>New Category
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
                <tbody v-else>
                  <tr>
                    <td colspan="8" style="text-align: center">
                      <img
                        v-if="showImage && categories.data.length === 0"
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
import { categoryDetails } from "../../store/categoryjs/categorydetails.js";

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


