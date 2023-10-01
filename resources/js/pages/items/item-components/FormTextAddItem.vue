<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <input
      v-if="inputType !== 'date'"
      v-model="localValue"
      :type="inputType"
      class="form-control"
      :placeholder="placeholder"
      @input="preventTyping"
    />
    <input
      v-else
      v-model="localValue"
      type="date"
      class="form-control"
      :placeholder="placeholder"
      @input="updateParent"
    />
    <span v-if="error" class="text-danger text-sm">{{ error }}</span>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      type: [String, Date],
      required: true,
    },
    error: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    inputType: {
      type: String,
      default: "text",
      validator: (value) =>
        ["text", "date", "integer"].includes(value.toLowerCase()),
    },
  },
  data() {
    return {
      localValue: this.value,
    };
  },
  methods: {
    updateParent() {
      this.$emit("update:value", this.localValue);
    },
    preventTyping(event) {
      if (this.inputType !== 'text') {
        event.preventDefault();
      }
    },
  },
};
</script>
