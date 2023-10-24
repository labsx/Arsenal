<template>
 <div class="col-md-12">
  <div class="form-group">
    <label>{{ label }}</label>
    <span class="text-danger"> *</span>
    <input
      :value="model"
      @input="updateModel"
      :type="type"
      class="form-control"
      :placeholder="placeholder"
      :class="{ 'is-invalid': error }"
      :style="{ borderColor: model ? 'green' : '' }"
    />
    <span v-if="error" class="text-danger text-sm">{{ error }}</span>
  </div>
 </div>
</template>

<script>
export default {
  props: {
    label: String,
    model: [String, Number],
    type: String,
    placeholder: String,
    error: String,
  },

  methods: {
    updateModel(event) {
      this.$emit('update:model', event.target.value);
    },
  },
};
</script>
