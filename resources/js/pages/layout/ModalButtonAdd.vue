<template>
  <div>
    <button
      class="btn btn-outline-primary ml-1 btn-sm"
      data-toggle="modal"
      :data-target="modalTarget" 
    >
      <i class="fa fa-plus-circle mr-1"></i>{{ title }}
    </button>
  </div>
</template>

<script>
export default {
  name: "AddFieldGroupsButton",
  props: {
    modalTarget: String, 
    title: String, 
  },
};
</script>
