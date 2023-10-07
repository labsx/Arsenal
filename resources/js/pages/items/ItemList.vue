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
              <!-- <div class="float-right ml-2">
                <button @click="printItems" class="btn btn-primary">
                  <i class="fa fa-print mr-1"></i> Print
                </button>
              </div> -->
              <!-- <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#createModal"
              >
                <i class="fa fa-plus-circle mr-1"></i>New Items
              </button> -->
<!-- 
                <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#createCategory"
              >
                <i class="fa fa-plus-circle mr-1"></i>New Category
              </button>
   
                <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#createParent"
              >
                <i class="fa fa-plus-circle mr-1"></i>Parent
              </button>

               <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#createCategoryItem"
              >
                <i class="fa fa-plus-circle mr-1"></i>Category Item
              </button> -->

               <!-- <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#createFieldName"
              >
                <i class="fa fa-plus-circle mr-1"></i>Add Field Name
              </button> -->

               <button
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#createFieldsGroup"
              >
                <i class="fa fa-plus-circle mr-1"></i>Add Fields Group
              </button>


              <!-- <button
                v-if="selectedItems.length > 0"
                @click="bulkDelete"
                class="btn btn-danger ml-2"
              >
                <i class="fa fa-trash ml-2"></i> Delete Selected
              </button> -->
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
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <!-- <th v-if="items.data.length > 0">
                      <input
                        type="checkbox"
                        v-model="selectAll"
                        @change="toggleSelectAll"
                      />
                    </th> -->
                    <th scope="col">Name</th>
                    <th scope="col">Parent Id</th>
                    <th scope="col">Field Group</th>
                  
                  </tr>
                </thead>
                <tbody v-if="categories.data.length > 0">
                  <tr v-for="item in categories.data" :key="item.id">
                    <!-- <td>
                      <input
                        type="checkbox"
                        @change="toggleSelection(item)"
                        :checked="isSelected(item)"
                      />
                    </td> -->
                    <td>{{ item.name }}</td>
                    <td>{{ item.parent_id }}</td>
                    <td>{{ item.field_group_id}}</td>
                    <!-- <td>
                      <span :class="getStatusClass(item.status)">{{
                        item.status
                      }}</span>
                    </td> -->
                    <!-- <td>
                      <div class="text-align-center">
                        <router-link
                          :to="`/admin/items/${item.id}/edit`"
                          v-if="!shouldDisableLink(item.status)"
                        >
                          <i
                            :class="
                              statusIconClass(
                                item.status,
                                item.count,
                                item.serial
                              )
                            "
                          ></i>
                        </router-link>

                        <template
                          v-if="item.count > 0 && item.status !== 'Broken'"
                        >
                          <router-link :to="`/admin/items/${item.id}/issue`">
                            <i
                              v-if="item.status !== 'Under Repair'"
                              class="fa fa-user-plus ml-2 text-secondary"
                            ></i>
                          </router-link>
                        </template>

                        <router-link
                          to=""
                          @click.prevent="deleteItems(item.id)"
                        >
                          <i class="fa fa-trash text-danger ml-2"></i>
                        </router-link>
                      </div>
                    </td> -->
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

  <!-- <ModalAdd :getItemsFn="getItems" /> -->
  <!-- <CategoryAdd />
  <CreateCategoryItem />
   <Parent/>
  <CreateFieldGroup /> -->
 
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, watch, reactive } from "vue";
import Swal from "sweetalert2";
import { deleteItemsData, bulkDeleteItemsData } from "../../store/swal.js";
import { printItemsData } from "../../store/print.js";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { formatDate } from "../../helper.js";
import { computed } from "vue";
import { useToastr } from "../../toastr";
import flatpickr from "flatpickr";
// import ModalAdd from "../../pages/items/ModalAddItem.vue";
//  import CategoryAdd from "../category/CategoryAdd.vue";
//   import CreateCategoryItem from "../../pages/items/CategoryItem.vue";
//  import Parent from "../category/Parent.vue";
// import CreateFieldGroup from "../../pages/items/FieldGroup.vue";


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

// const fetchCategory = () => {
//   axios
//     .get("/items/all")
//     .then((response) => {
//       items.value.data = response.data;
//     })
//     .catch((error) => {
//       console.error("Error fetching all items:", error);
//     });
// };

// const printItems = () => {
//   printItemsData(items.value.data, formatDate);
// };

// const icon = computed(() => (status) => {
//   if (status === "Good") {
//     return "fa fa-user-plus";
//   } else {
//     return "fa fa-user-plus";
//   }
// });

// const statusIconClass = computed(() => (status) => {
//   if (status === "Good") {
//     return "fa fa-edit";
//   } else if (status === "issued") {
//     return "fa fa-exclamation-circle text-warning";
//   } else if (status === "Broken") {
//     return "fa fa-times-circle text-danger";
//   } else if (status === "Under Repair") {
//     return "fa fa-edit";
//   } else {
//     return "fa fa-user-plus";
//   }
// });

// const disabledStatuses = ["Broken", "issued"];

// const shouldDisableLink = (status) => {
//   return disabledStatuses.includes(status);
// };

// const handleLinkClick = (status, event) => {
//   if (isStatusBad(status) || isStatusIssued(status)) {
//     event.preventDefault();
//   }
// };

// const isStatusBad = (status) => {
//   return status === "Broken";
// };

// const isStatusIssued = (status) => {
//   return status === "issued";
// };

// const getItems = (page = 1, status = null) => {
//   let url = `/items?page=${page}`;
//   if (status) {
//     url += `&status=${status}`;
//   }

//   axios
//     .get(url)
//     .then((response) => {
//       items.value = response.data;
//     })
//     .catch((error) => {
//       console.error("Error fetching items:", error);
//     });
// };

// const deleteItems = (id) => {
//   deleteItemsData()
//     .then((result) => {
//       if (result.isConfirmed) {
//         return axios.delete(`/items/${id}`);
//       }
//       throw new Error("Deletion not confirmed.");
//     })
//     .then(() => {
//       items.value.data = items.value.data.filter((item) => item.id !== id);
//       Swal.fire("Deleted!", "Item has been deleted.", "success");
//       getItems();
//     })
//     .catch((error) => {
//       console.error("Error deleting items:", error);
//     });
// };

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

// const getStatusClass = (status) => {
//   if (status === "Good") {
//     return "badge badge-success good-status";
//   } else if (status === "issued") {
//     return "badge badge-primary issued-status";
//   } else if (status === "Broken") {
//     return "badge badge-danger bad-status";
//   } else if (status === "Under Repair") {
//     return "badge badge-warning bad-status";
//   } else {
//     return "badge badge-default";
//   }
// };

// const bulkDelete = () => {
//   axios
//     .delete("/items", {
//       data: {
//         ids: selectedItems.value,
//       },
//     })
//     .then((response) => {
//       items.value.data = items.value.data.filter(
//         (item) => !selectedItems.value.includes(item.id)
//       );
//       selectedItems.value.splice(0);
//       bulkDeleteItemsData();
//       getItems();
//     })
//     .catch((error) => {
//       console.error("Error deleting items:", error);
//     });
// };

// const isSelected = (item) => {
//   return selectedItems.value.includes(item.id);
// };

// const selectedItems = ref([]);
// const selectAll = ref(false);

// const toggleSelectAll = () => {
//   if (selectAll.value) {
//     selectedItems.value = items.value.data.map((item) => item.id);
//   } else {
//     selectedItems.value = [];
//   }
// };
// const toggleSelection = (item) => {
//   const index = selectedItems.value.indexOf(item.id);
//   if (index === -1) {
//     selectedItems.value.push(item.id);
//   } else {
//     selectedItems.value.splice(index, 1);
//   }
// };

onMounted(() => {
  getCategory();
  // getItems();

  // flatpickr(".flatpickr", {
  //   enableTime: true,
  //   dateFormat: "Y-m-d h:i K",
  //   defaultHour: 10,
  // });
});
</script>

