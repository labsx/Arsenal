<template>
  <tr>
    <td colspan="8" style="text-align: center">
      <img v-if="showImage" :src="imagePath" alt="No Data Found" style="max-width: 750px; height: auto" />
      <p style="font-weight: bold; color: red">No data found !</p>
    </td>
  </tr>
</template>

<script setup>
const { showImage, imagePath } = defineProps(["showImage", "imagePath"]);
</script>