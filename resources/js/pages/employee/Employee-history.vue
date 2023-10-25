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
                    {{ form.first_name }} {{ form.last_name }}
                    <span v-if="form.position" class="small-text" style="font-size: 18px"
                      >({{ form.position }})</span
                    >
                  </h4>
                </div>
                <div class="container"></div>
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
                        ><a href="javascript:;">
                          {{ itemNames[history.item_id] }}</a
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
import { formatdmy } from "../../helper.js";
import { formatDate } from "../../helper.js";
import { employeeHistory } from "../../store/employeejs/employee-history.js";

const { form, histories, itemNames } = employeeHistory();
</script>

<style scoped>
@import url("./resources/css/itemdetails.css");
</style>
