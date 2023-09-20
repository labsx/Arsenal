<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Item List </h1>
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
               <button class="btn btn-primary" data-toggle="modal" data-target="#createModal"> 
                  <i class="fa fa-plus-circle mr-1"></i> Add New Items
                </button>

                <!-- <button v-if="selectedItems.length > 0" @click="bulkDelete" class="btn btn-danger ml-2">
                  <i class="fa fa-trash ml-2"></i> Delete Selected
              </button> -->
            </div>
              
              <div>
                <!-- <div class="input-group">
                <input v-model="searchQuery" type="text" class="form-control" placeholder="Search...">
                  <div class="input-group-append">
                      <span class="input-group-text"><i class="fa fa-search text-primary" aria-hidden="true"></i></span>
                  </div>
                </div> -->
              </div>
          </div>
          <div class="card">
            <div class="card-body">
              <table class="table table-bordered">
                <thead >
                  <tr>
                   
                    <th scope="col">Items</th>
                    <th scope="col">Count</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date Stored</th>
                    <th scope="col">Status</th>
                    <th scope="col">Manage</th>
                   
                  </tr>
                </thead>
                <tbody>
                  <tr >
                     <td>
                       Mug
                    </td>
                    <td>20</td>
                    <td>Good</td>
                    <td>Date</td>
                    <td>Red</td>
                  
                   
                    <td >  
                      
                      <!-- <div class="text-align-center">
                          <router-link :to="`/admin/items/${item.id}/edit`" v-if="!shouldDisableLink(item.status)">
                          <i :class="statusIconClass(item.status)"></i>
                      </router-link>

                      <router-link :to="`/admin/items/${item.id}/issue`" v-if="!shouldDisableLink(item.status)">
                         <i :class="icon(item.status)" class="ml-2 text-secondary"></i>
                      </router-link>

                      <router-link to="" @click.prevent="deleteItems(item.id)">
                        <i class="fa fa-trash text-danger ml-2"></i>
                      </router-link>
                      </div> -->
                    
                    </td>
                  </tr>
                </tbody>
              
              </table>
            </div>
          </div>
          <div>
         <div class="btn-group float-right">
            <router-link to="/admin/items/list"  class="btn btn-secondary">
                <span class="mr-1">Items 1</span>
                <span class="badge badge-pill badge-info"></span>
            </router-link>

            <router-link to="/admin/list/count"  class="btn btn-default">
                <span class="mr-1">Items 2</span>
                <span class="badge badge-pill badge-primary"></span>
            </router-link>
        </div>
          </div>

            
        </div>
      </div>
    </div>
  </div>

  <ModalAddItemsCount/>

</template>

 <script setup>

 import ModalAddItemsCount from '../../pages/items-count/ModalItemsCount.vue';
 import flatpickr from "flatpickr";
 import { onMounted } from 'vue';

onMounted (() => {

     flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d h:i K",
        defaultHour: 10,
    });
});

 </script>
