<template>
  <ContentHeader title="Issue Item" data="item" datas="issue" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Issue item</h3>
            </div>

            <form>
              <div class="card-body">
                <div class="form-group">
                  <input
                    v-model="form.item_id"
                    type="text"
                    class="form-control"
                    item_="appName"
                    placeholder="Enter app display name"
                    style="display: none"
                  />
                </div>

                <div class="form-group">
                  <label>Employee List</label>
                  <span class="text-danger"> *</span>
                  <select
                    class="form-control"
                    v-model="form.employee_id"
                    :class="{ 'is-invalid': errors.employee_id }"
                  >
                    <option value="" disabled>Select an employee</option>
                    <option
                      v-for="employee in employees"
                      :key="employee.id"
                      :value="employee.id"
                    >
                      {{ employee.first_name }} {{ employee.last_name }}
                    </option>
                  </select>
                  <span
                    v-if="errors && errors.employee_id"
                    class="text-danger text-sm"
                    >{{ errors.employee_id[0] }}</span
                  >
                </div>

                <div class="form-group">
                  <label for="appName">Remarks</label>
                  <input
                    v-model="form.remarks"
                    type="text"
                    class="form-control"
                    id="appName"
                    placeholder="Enter remarks"
                    :class="{ 'is-invalid': errors.remarks }"
                  />
                  <span
                    v-if="errors && errors.remarks"
                    class="text-danger text-sm"
                    >{{ errors.remarks[0] }}</span
                  >
                </div>

                <div class="form-group">
                  <label for="appName">Date Issued</label>
                   <span class="text-danger"> *</span>
                  <input
                    v-model="form.issued_at"
                    type="date"
                    class="form-control"
                    id="appName"
                    placeholder="Enter issued date"
                    style="background-color: white"
                    :class="{ 'is-invalid': errors.issued_at }"
                  />
                  <span
                    v-if="errors && errors.issued_at"
                    class="text-danger text-sm"
                    >{{ errors.issued_at[0] }}</span
                  >
                </div>
              </div>

              <div class="card-footer">
                <button
                  @click.prevent="saveIssue"
                  type="submit"
                  class="btn btn-primary"
                >
                  <i class="fa fa-save mr-1"></i>Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { formatDate } from "../../helper.js";
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { IssueItem } from "../../store/itemjs/issueitem.js";

const {
  getItemsData,
  getEmployee,
  setCurrentDate,
  employees,
  form,
  saveIssue,
  errors,
} = IssueItem();
</script>


