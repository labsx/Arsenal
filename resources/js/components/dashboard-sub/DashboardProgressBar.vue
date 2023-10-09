  <template>
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Items Progressbar</h6>
      </div>

      <div class="card-body">
        <h4 class="small font-weight-bold">
          Decommissioned Items
          <span class="float-right">{{ badItemCountPercent }}%</span>
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
          Operating Items
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

        <h4 class="small font-weight-bold mt-2">
          Under Repair Items
          <span class="float-right">{{ underRepairItemCountPercent }}%</span>
        </h4>
        <div class="progress">
          <div
            class="progress-bar bg-warning"
            role="progressbar"
            :style="{ width: underRepairItemCountPercent + '%' }"
            :aria-valuenow="underRepairItemCountPercent"
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
const underRepairItemCountPercent = ref([]);

const countAll = () => {
  axios
    .get("/dashboard/progress")
    .then((response) => {
      goodItemCountPercent.value = response.data.goodItemCountPercent;
      badItemCountPercent.value = response.data.badItemCountPercent;
      issuedItemCountPercent.value = response.data.issuedItemCountPercent;
      underRepairItemCountPercent.value =
        response.data.underRepairItemCountPercent;
    })
    .catch((error) => {
      console.error(error);
    });
};

onMounted(() => {
  countAll();
});
</script>
