<template>
  <ContentHeader title="Item List" data="item" datas="list" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex justify-content-between mb-2">
            <div>
              <router-link to="/admin/add/item">
                <button type="button" class="btn btn-outline-primary btn-sm">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  Add item
                </button>
              </router-link>

              <button
                @click="printItems"
                class="btn btn-outline-primary btn-sm ml-2"
              >
                <i class="fa fa-print mr-1"></i> Print
              </button>
            </div>
            <Search v-model="searchQuery" />
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table align-middle">
                <thead v-if="items.data.length > 0">
                  <tr>
                    <th scope="col">Item Name</th>
                    <th scope="col">Serial</th>
                    <th scope="col">Model</th>
                    <th scope="col">Mfg. Date</th>
                    <th scope="col">Manufacturer</th>
                    <th scope="col">Manufacturer address</th>
                    <th scope="col">Unit&nbsp;price</th>
                    <th scope="col">Status</th>
                    <!-- <th scope="col">Barcode</th> -->
                    <th scope="col">Option</th>
                  </tr>
                </thead>
                <tbody v-if="items.data.length > 0">
                  <tr v-for="item in items.data" :key="item.id">
                    <td>{{ item.name }}</td>
                    <td>{{ item.serial }}</td>
                    <td>{{ item.model }}</td>
                    <td>{{ formatDate(item.mfg_date) }}</td>
                    <td>
                      {{ item.manufacturer ? item.manufacturer : "none" }}
                    </td>
                    <td>{{ item.location ? item.location : "none" }}</td>
                    <td>{{ formatPrice(item.price) }}</td>
                    <td>
                      <span :class="getStatusClass(item.status)">{{
                        item.status
                      }}</span>
                    </td>

                    <td>
                      <router-link :to="`/admin/items/${item.id}/details`">
                        <i class="fas fa-eye text-primary mr-2"></i>
                      </router-link>

                      <router-link
                        v-if="
                          !['issue', 'decommissioned'].includes(item.status)
                        "
                        :to="`/admin/items/${item.id}/edit`"
                      >
                        <i class="fas fa-edit text-info"></i>
                      </router-link>

                      <router-link
                        to=""
                        @click.prevent="deleteItems(item.id)"
                        v-if="
                          !hasHistory(item.id) &&
                          item.status !== 'decommissioned'
                        "
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
                        v-if="showImage && items.data.length === 0"
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
              :data="items"
              @pagination-change-page="getItems"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import JsBarcode from "jsbarcode";
import { formatDate } from "../../helper.js";
import imagePath from "/resources/image/no data.gif";
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { itemList } from "../../store/itemjs/itemlist.js";
import Search from "../../pages/layout/Search.vue";

const {
  formatPrice,
  printItems,
  deleteItems,
  items,
  searchQuery,
  getStatusClass,
  showImage,
  getItems,
  hasHistory,
} = itemList();
</script>
 
