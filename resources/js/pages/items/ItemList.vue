<template>
  <div>
    <h1>Item Details</h1>
    <div v-for="item in items" :key="item.id">
      <p>Name: {{ item.name }}</p>
      <h2>Attributes</h2>
      <ul>
        <li v-for="attribute in item.attributes" :key="attribute.id">
          {{ attribute.name }} - {{ attribute.value }}
        </li>
      </ul>
    </div>
    <div v-if="items.length === 0">
      No items found.
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";  

const items = ref([]);

const getItemsAndAttributes = () => {
  axios.get('/items_and_attributes/all')
    .then((response) => {
      console.log('Response:', response.data);  // Print the response to the console
      if (response.data) {
        items.value = response.data || [];  
      }
    })
    .catch((error) => {
      console.error('Error fetching items and attributes:', error); 
    });
};

onMounted(() => {
  getItemsAndAttributes();
});
</script>
