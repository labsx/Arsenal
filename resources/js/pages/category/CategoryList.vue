<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Item List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Item List</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
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

              <button
                class="btn btn-outline-primary ml-1 btn-sm"
                data-toggle="modal"
                data-target="#createParent"
              >
                <i class="fa fa-plus-circle mr-1"></i>Sub Category
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
                  <tr>
                    <th scope="col">Name</th>
                    <!-- <th scope="col">Parent Id</th> -->
                    <th scope="col">Field Group</th>
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="categories.data.length > 0">
                  <tr v-for="category in categories.data" :key="category.id">
                    <td>{{ category.name }}</td>
                    <!-- <td>{{ category.parent_id }}</td> -->
                    <td>{{ category.field_group_id }}</td>
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
                    <td colspan="7" class="text-danger text-center">
                      No Data found !...
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div>
            <Bootstrap4Pagination
              :data="categories"
              @pagination-change-page="getCategory"
            />
          </div>
        </div>
      </div>
    </div>
  </div>

  <CategoryAdd />
  <CategorySub />
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch, reactive } from "vue";
import Swal from "sweetalert2";
import { deleteCategoryData, bulkDeleteItemsData } from "../../store/swal.js";
import { printItemsData } from "../../store/print.js";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { formatDate } from "../../helper.js";
import { computed } from "vue";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
import CategoryAdd from "./CategoryAdd.vue";
import CategorySub from "./CategorySub.vue";
import { debounce } from "lodash";

const toastr = useToastr();
const errors = ref([]);
const categories = ref({ data: [] });

const getCategory = (page = 1) => {
  axios
    .get(`/category?page=${page}`)
    .then((response) => {
      categories.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching category:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/category", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      categories.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

watch(
  searchQuery,
  debounce(() => {
    search();
  }, 300)
);

const deleteCategory = (id) => {
  deleteCategoryData()
    .then((result) => {
      if (result.isConfirmed) {
        return axios.delete(`/category/${id}`);
      }
      throw new Error("Deletion not confirmed.");
    })
    .then(() => {
      categories.value.data = categories.value.data.filter(
        (category) => category.id !== id
      );
      Swal.fire("Deleted!", "category has been deleted.", "success");
      getItems();
    })
    .catch((error) => {
      console.error("Error deleting event:", error);
    });
};

onMounted(() => {
  getCategory();
});
</script>

