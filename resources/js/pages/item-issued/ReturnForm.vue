<template>
  <ContentHeader title="" data="item" datas="return" />
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Return item</h3>
            </div>

            <form>
              <div class="card-body">
                <TextInput :model="form.history_id" @update:model="form.history_id = $event" type="text"  style="display: none" />
                <TextInput label="Remarks" :model="form.remarks" :error="errors.remarks ? errors.remarks[0] : null" @update:model="form.remarks = $event" type="text" placeholder = "Enter remarks"/>
                <StatusDropdown v-bind:value="form.status" @update:value="form.status = $event" v-bind:error="errors.status ? errors.status[0] : null" />
                <TextInput label="Return Date" :model="form.return_at" :error="errors.return_at ? errors.return_at[0] : null" @update:model="form.return_at = $event" type="date" />
              </div>
              <div class="card-footer">
                <button
                  @click.prevent="UpdateHistory"
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
import ContentHeader from "../../pages/layout/ContentHeader.vue";
import { returnFormItem } from "../../store/itemjs/returnitem.js";
import TextInput from "../../pages/layout/TextInput.vue";
import StatusDropdown from "../../pages/layout/StatusDropdown.vue";

const { errors, form, setCurrentDate, UpdateHistory, returnItem } =
  returnFormItem();
</script>


