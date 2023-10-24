<template>
  <div class="col-md-12">
    <div class="form-group">
      <label  :class="{ 'd-flex align-items-center': smallText }"
        >{{ label }}
        <small class="form-text text-muted ml-2" v-if="smallText"
          >( {{ smallMessage }} )</small
        >
      </label>
      <span class="text-danger" v-if="showAsterisk"> *</span>
      <input
        :value="model"
        @input="updateModel"
        :type="type"
        class="form-control"
        :placeholder="placeholder"
        :class="{ 'is-invalid': error }"
      />
      <span v-if="error" class="text-danger text-sm">{{ error }}</span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    smallMessage: String,
    label: String,
    model: [String, Number],
    type: String,
    placeholder: String,
    error: String,
    showAsterisk: {
      type: Boolean,
      default: true,
    },
     smallText: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    updateModel(event) {
      this.$emit("update:model", event.target.value);
    },
  },
};
</script>
