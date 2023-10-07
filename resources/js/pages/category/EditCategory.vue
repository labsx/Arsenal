<template>
  <label for="categoryName">Category Name: </label>
  <input v-model="form.name" type="text" id="categoryName" />
  <button @click="saveCategory">Save</button>
</template>


<script setup>
import axios from "axios";
import { reactive, onMounted, ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useToastr } from "../../toastr";

const router = useRouter();
const route = useRoute();
const toastr = useToastr();
const errors = ref([]);

const form = reactive({
  name: "",
});

const ItemDetails = () => {
  axios
    .get(`/category/${route.params.id}/show`)
    .then(({ data }) => {
      console.log("Category data:", data); // Log the category data
      if (data && data.name) {
        form.name = data.name;
      } else {
        console.error("Category name not found in the response data.");
      }
    })
    .catch((error) => {
      console.error("Error fetching category details:", error);
    });
};

const saveCategory = () => {
  axios
    .put(`/category/${route.params.id}`, { name: form.name })
    .then(() => {
      toastr.success("Category updated successfully!");
    })
    .catch((error) => {
      console.error("Error updating category:", error);
    });
};

onMounted(() => {
  ItemDetails();
});
</script>
