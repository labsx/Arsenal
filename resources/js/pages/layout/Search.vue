<template>
  <div>
    <div class="input-group">
      <input
        v-model="searchQuery"
        type="text"
        class="form-control"
        placeholder="Search..."
      />
      <div class="input-group-append">
        <span class="input-group-text"
          ><i class="fa fa-search text-primary" aria-hidden="true"></i
        ></span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: String,
  },
  emits: ['update:modelValue'],
  data() {
    return {
      searchQuery: this.modelValue,
    };
  },
  watch: {
    searchQuery() {
      this.$emit('update:modelValue', this.searchQuery);
    },
  },
};
</script>

