<template>
  <ContentHeader title="Category list name" data="category" datas="list name" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <button
                class="btn btn-outline-primary ml-1 btn-sm"
                data-toggle="modal"
                data-target="#createParent"
              >
                <i class="fa fa-plus-circle mr-1"></i> Category list name
              </button>
            </div>
            <div>
              <!-- <div class="input-group">
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
              </div> -->
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table align-middle">
                <thead v-if="parents.data.length > 0">
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="parents.data.length > 0">
                  <tr v-for="parent in parents.data" :key="parent.id">
                    <td>{{ parent.name }}</td>
                    <td>{{ formatDate(parent.created_at) }}</td>
                    <td>
                      <!-- <router-link
                        :to="`/admin/subcategory/${parent.id}/item-filter`"
                      >
                        <i class="fas fa-eye mr-2"></i>
                      </router-link> -->

                      <router-link :to="`/admin/subcategory/${parent.id}/edit`">
                        <i class="fas fa-edit mr-2"></i>
                      </router-link>

                      <router-link
                        to=""
                        @click.prevent="deleteParentData(parent.id)"
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
                        v-if="showImage && parents.data.length === 0"
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
              :data="parents"
              @pagination-change-page="getFilterParent"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <CategorySub :getFilterParentFn="getFilterParent" />
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, watch } from "vue";
import { getCurrentInstance } from "vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { debounce } from "lodash";
import { formatDate } from "../../helper.js";
import Swal from "sweetalert2";
import { deleteParent } from "../../store/swal.js";
import CategorySub from "./CategorySub.vue";
import imagePath from "/resources/image/no data.gif";
import ContentHeader from "../../pages/layout/ContentHeader.vue";

const showImage = ref(false);
const route = getCurrentInstance().proxy.$route;
const parents = ref({ data: [] });

const getFilterParent = (page = 1) => {
  const fieldId = route.params.id;

  axios
    .get(`/parent/${fieldId}/show?page=${page}`)
    .then((response) => {
      parents.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

const searchQuery = ref(null);
const search = () => {
  axios
    .get("/parent", {
      params: {
        query: searchQuery.value,
      },
    })
    .then((response) => {
      parents.value = response.data;
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

const deleteParentData = (id) => {
  deleteParent()
    .then((result) => {
      if (result.isConfirmed) {
        return axios.delete(`/parent/${id}`);
      }
      throw new Error("Deletion not confirmed.");
    })
    .then(() => {
      parents.value.data = parents.value.data.filter(
        (parent) => parent.id !== id
      );
      Swal.fire("Deleted!", "Parent has been deleted.", "success");
      getItems();
    })
    .catch((error) => {
      console.error("Error deleting parent:", error);
    });
};

onMounted(() => {
  getFilterParent();

  setTimeout(() => {
    if (parents.value.data.length === 0) {
      showImage.value = true;
    }
  }, 100);
});
</script>
