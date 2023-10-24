<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <textarea
      :value="model"
      @input="updateModel"
      class="form-control"
      :placeholder="placeholder"
      :class="{ 'is-invalid': error }"
      :style="{ borderColor: model ? 'green' : '' }"
    ></textarea>
    <span v-if="error" class="text-danger text-sm">{{ error }}</span>
  </div>
</template>

<script>
export default {
  props: {
    label: String,
    model: [String, Number],
    placeholder: String,
    error: String,
  },

  methods: {
    updateModel(event) {
      this.$emit("update:model", event.target.value);
    },
  },
};
</script>
