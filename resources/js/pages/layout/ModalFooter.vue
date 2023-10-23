<template>
  <div class="modal-footer">
    <button
      type="button"
      class="btn btn-outline-secondary btn-sm"
      data-dismiss="modal"
    >
      <i class="fa fa-times mr-2 text-danger"></i>Close
    </button>
    <button @click.prevent="dataTosave" type="submit" class="btn btn-outline-primary btn-sm">
      <i class="fa fa-save mr-2"></i>Save Item
    </button>
  </div>
</template>

<script>
export default {
  props: {
    dataTosave: Function, 
  },
};
</script>
