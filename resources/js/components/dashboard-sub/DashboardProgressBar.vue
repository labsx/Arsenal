<template>
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Items</h6>
      </div>

      <div class="card-body">
        <h4 class="small font-weight-bold">
          Bad Items <span class="float-right">{{ badItemCountPercent }}%</span>
        </h4>
        <div class="progress mb-4">
          <div
            class="progress-bar bg-danger"
            role="progressbar"
            :style="{ width: badItemCountPercent + '%' }"
            :aria-valuenow="badItemCountPercent"
            aria-valuemin="0"
            aria-valuemax="100"
          ></div>
        </div>
        <h4 class="small font-weight-bold">
          Issued Items
          <span class="float-right">{{ issuedItemCountPercent }}%</span>
        </h4>
        <div class="progress mb-4">
          <div
            class="progress-bar"
            role="progressbar"
            :style="{ width: issuedItemCountPercent + '%' }"
            :aria-valuenow="issuedItemCountPercent"
            aria-valuemin="0"
            aria-valuemax="100"
          ></div>
        </div>
        <h4 class="small font-weight-bold">
          Good Items
          <span class="float-right">{{ goodItemCountPercent }}%</span>
        </h4>
        <div class="progress">
          <div
            class="progress-bar bg-success"
            role="progressbar"
            :style="{ width: goodItemCountPercent + '%' }"
            :aria-valuenow="goodItemCountPercent"
            aria-valuemin="0"
            aria-valuemax="100"
          ></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const goodItemCountPercent = ref([]);
const badItemCountPercent = ref([]);
const issuedItemCountPercent = ref([]);

const countAll = () => {
  axios.get('/dashboard/count')
   .then((response) => {
      goodItemCountPercent.value = response.data.goodItemCountPercent;
      badItemCountPercent.value = response.data.badItemCountPercent;
      issuedItemCountPercent.value = response.data.issuedItemCountPercent;
    })
    .catch((error) => {
      console.error(error);
    });
};

onMounted(() =>{
  countAll();
});
</script>
