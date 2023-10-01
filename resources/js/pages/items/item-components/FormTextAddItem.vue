<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <textarea
      v-if="inputType === 'textarea'"
      v-model="localValue"
      class="form-control"
      :placeholder="placeholder"
      style="height: 100px;"
      @input="preventTyping"
    ></textarea>
    <input
      v-else
      v-model="localValue"
      :type="inputType"
      :class="{ 'flatpickr': inputType === 'date' }"
      style="background: white;"
      class="form-control"
      :placeholder="placeholder"
      @input="preventTyping"
    />
   <span v-if="errors && errors[errorKey]" class="text-danger text-sm">{{ errors[errorKey][0] }}</span>
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
    placeholder: {
      type: String,
      default: "",
    },
    inputType: {
      type: String,
      default: "text",
      validator: (value) => ["text", "date", "integer", "textarea"].includes(value.toLowerCase()),
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
    errorKey: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      localValue: this.value,
    };
  },
  watch: {
    value(newValue) {
      this.localValue = newValue;
    },
    localValue(newVal) {
      this.$emit("update:value", newVal);
    },
    errors: {
      handler: 'handleErrorsChange',
      deep: true
    }
  },
  methods: {
    preventTyping(event) {
      if (this.inputType !== "text") {
        event.preventDefault();
      }
    },
    handleErrorsChange() {
      if (this.errors && this.errors[this.errorKey]) {
        this.localError = this.errors[this.errorKey][0];
      } else {
        this.localError = null;
      }
    }
  },
  computed: {
    localError() {
      return this.errors && this.errors[this.errorKey] ? this.errors[this.errorKey][0] : null;
    }
  }
};
</script>
