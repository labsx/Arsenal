<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <select
      v-model="selectedValue"
      class="form-control"
       :style="{ borderColor: model ? 'green' : '' }"
    >
      <option value="" disabled selected hidden>{{ placeholder }}</option>
      <option
        v-for="item in items"
        :key="item.id"
        :value="item.id"
      >
        {{ item.name }}
      </option>
    </select>
  </div>
</template>

<script>
export default {
  props: {
    label: String,
    placeholder: String,
    items: Array,
    model: [String, Number],
    updateModel: Function,
  },
  computed: {
    selectedValue: {
      get() {
        return this.model;
      },
      set(value) {
        this.updateModel(value);
      }
    }
  },
};
</script>
