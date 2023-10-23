<template>
     <div class="modal-header">
          <h5 class="modal-title" id="addEmployee">{{ header }}</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
</template>

<script>
export default {
  props: {
    header: {
      type: String,
      required: true,
    },
  },
};
</script>