<template>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Fields Name</th>
        <th scope="col">Description</th>
        <th scope="col">Option</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(field, index) in field_groups" :key="field.id">
        <th scope="row">{{ index + 1 }}</th>
        <td>{{ field.name }}</td>
        <td>{{ field.description }}</td>
        <td>
          <router-link :to="`/admin/fields/${field.id}/add`">
            <i class="fas fa-eye"></i>
          </router-link>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const field_groups = ref();

const getFieldsGroups = () => {
  axios
    .get("/field-group")
    .then((response) => {
      field_groups.value = response.data;
    })
    .catch((error) => {
      console.error("An error occurred:", error);
    });
};

onMounted(() => {
  getFieldsGroups();
});
</script>