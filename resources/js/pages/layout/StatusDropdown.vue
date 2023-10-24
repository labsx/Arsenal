<template>
  <div class="form-group">
    <label for="status">Status</label>
    <span class="text-danger"> *</span>
    <select
      v-model="selectedStatus"
      id="status"
      class="form-control"
      :class="{ 'is-invalid': error }"
      @change="updateStatus"
      :style="{ borderColor: model ? 'green' : '' }"
    >
      <option value="" disabled selected hidden>Select Status</option>
      <option value="operating">Operating</option>
      <option value="decommissioned">Decommissioned</option>
      <option value="under repair">Under Repair</option>
    </select>
    <span v-if="error" class="text-danger text-sm">{{ error }}</span>
  </div>
</template>

<script>
export default {
  props: {
    value: String,
    error: String,
  },
  data() {
    return {
      selectedStatus: this.value,
    };
  },
  methods: {
    updateStatus() {
      this.$emit("update:value", this.selectedStatus);
    },
  },
};
</script>
