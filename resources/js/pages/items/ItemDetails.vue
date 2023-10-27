<template>
  <div class="row">
    <div class="col-md-12">
      <div id="content" class="content content-full-width">
        <div class="profile mt-2">
          <div class="profile-header">
            <div class="profile-header-cover"></div>
            <div class="profile-header-content">
              <div class="profile-header-info">
                <div class="column" style="max-height: 100px; overflow-y: auto">
                  <h4 class="no-margin">
                    {{ form.name }}
                    <span class="small-text" style="font-size: 18px"
                      >({{ form.status }})</span
                    >
                  </h4>
                  <p class="">
                    <img
                      :src="generateBarcode(form.barcode)"
                      alt="Barcode"
                      style="height: 50px; width: 150px"
                    />
                  </p>
                </div>
                <div class="column" style="max-height: 100px; overflow-y: auto">
                  <h5>Details</h5>
                  <p class="no-margin">Model: {{ form.serial }}</p>
                  <p class="no-margin">Model: {{ form.model }}</p>
                  <p class="no-margin">
                    Price: {{ form.price ? formatPrice(form.price) : "none" }}
                  </p>
                  <p class="no-margin">
                    Mfg. Date:
                    {{ form.mfg_date ? formatDate(form.mfg_date) : "none" }}
                  </p>
                  <p class="no-margin">
                    Manufacturer:
                    {{ form.manufacturer ? form.manufacturer : "none" }}
                  </p>
                  <p class="no-margin">
                    Location: {{ form.location ? form.location : "none" }}
                  </p>
                  <p class="no-margin">
                    Warranty:
                     {{ form.warranty ? formatDate(form.warranty) : "none" }} /
                     {{ calculateWarrantyRemainingDays() }}
                     {{ calculateWarrantyRemainingDays() === 1 ? 'day' : calculateWarrantyRemainingDays() === 0 ? 'day' : 'days' }}
                  </p>
                  <p class="no-margin">
                    Insurance: {{ form.insurance ? form.insurance : "none" }}
                  </p>
                  <p class="no-margin">
                    Net Weight: {{ form.net_weight ? form.net_weight : "none" }}
                  </p>
                </div>
                <div class="column" style="max-height: 100px; overflow-y: auto">
                  <h5>Attributes</h5>
                  <p v-for="(attribute, index) in form.value" :key="index"></p>
                  <p
                    class="no-margin"
                    v-for="(attribute, index) in form.value"
                    :key="index"
                  >
                    {{ attribute.name }} : {{ attribute.value }}
                  </p>
                </div>

                <div class="container"></div>
                <router-link
                  v-if="
                    status !== 'under repair' && status !== 'decommissioned'
                  "
                  :to="
                    status === 'operating'
                      ? `/admin/items/${form.id}/issue`
                      : `/admin/items/${historyId}/return`
                  "
                  class="btn btn-outline-info btn-sm"
                >
                  <i class="fas fa-edit"></i>
                  {{ status === "operating" ? "Issue" : "Return" }}
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <div
          class="profile-content ml-5"
          style="max-height: 650px; overflow-y: auto"
        >
          <div class="tab-content p-0">
            <div class="tab-pane fade active show" id="profile-post">
              <ul
                class="timeline"
                v-for="history in histories"
                :key="history.id"
              >
                <li>
                  <div class="timeline-time">
                    <span class="date">{{ formatdmy(history.issued_at) }}</span>
                  </div>
                  <div class="timeline-icon">
                    <a href="javascript:;">&nbsp;</a>
                  </div>
                  <div class="timeline-body">
                    <div class="timeline-header">
                      <span class="username"
                        ><a href="javascript:;"
                          >{{ history.employee.first_name }}
                          {{ history.employee.last_name }}</a
                        >
                        <small></small
                      ></span>
                      <span class="pull-right text-dark">
                        ( {{ history.status }} )</span
                      >
                    </div>
                    <div class="timeline-content" v-if="history.return_at">
                      <p class="no-margin text-black">
                        Remarks: {{ history.remarks }}
                      </p>
                      <p class="no-margin">
                        Return Date:
                        {{
                          history.return_at
                            ? formatDate(history.return_at)
                            : "not yet returned"
                        }}
                      </p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { useToastr } from "../../toastr";
import { formatDate } from "../../helper.js";
import { formatdmy } from "../../helper.js";
import { itemDetails } from "../../store/itemjs/itemdetails.js";

const {
  fetchEmployeeData,
  fetchHistories,
  getItems,
  getAttributes,
  history,
  addAttribute,
  removeAttribute,
  form,
  histories,
  historyId,
  status,
  generateBarcode,
  formatPrice,
  calculateWarrantyRemainingDays,
} = itemDetails();
</script>

<style scoped>
@import url("./resources/css/itemdetails.css");
</style>

