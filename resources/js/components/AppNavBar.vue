<template>
     <nav class="main-header navbar navbar-expand" :class="settingStore.theme === 'dark' ? 'navbar-dark': 'navbar-light'">
   <ul class="navbar-nav">
      <li class="nav-item" id="toggleMenuIcon">
         <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
         </a>
      </li>

      <li class="nav-item d-none d-sm-inline-block">
         <a @click.prevent="settingStore.changeTheme" href="#" class="nav-link">
            <i :class="settingStore.theme === 'dark' ? 'fa fa-moon' : 'fa fa-sun'"></i>
         </a>
      </li>
   </ul>

      <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" @click="notifyNewItem">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ totalAddedItems }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ totalAddedItems }} Notifications</span>
          <div class="dropdown-divider"></div>
          <li v-for="(newItem, index) in newItems" :key="index">
            <a href="#" class="dropdown-item">
              {{ newItem.name }} 
            </a>
          </li>
          <div class="dropdown-divider"></div>
        </div>
      </li>
    </ul>
</nav>
</template>

<script setup>
import { useSettingStore } from '../store/themeStore.js';
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';

const newItems = ref([]);
const addedItems = ref({});
const totalAddedItems = ref(0);

const clearNewItems = () => {
  // Clear new items once they are displayed
  newItems.value = [];
};

const notifyNewItem = () => {
  setInterval(() => {
    checkForNewItemInDatabase();
  }, 5000);
};

const checkForNewItemInDatabase = () => {
  axios
    .get("/notification")
    .then((response) => {
      const itemCounts = response.data.itemCounts;
      const itemNames = response.data.itemNames;

      // Update the new items
      const updatedNewItems = itemNames.map((name, index) => ({
        name,
        count: itemCounts[index]
      }));

      // Update the added items and their counts
      itemNames.forEach((itemName, index) => {
        if (!addedItems.value.hasOwnProperty(itemName)) {
          addedItems.value[itemName] = 0;
        }
        addedItems.value[itemName] += itemCounts[index];
      });

      // Update the total added items count
      totalAddedItems.value = Object.keys(addedItems.value).length;

      // Clear new items once they are displayed
      clearNewItems();

      // Display a notification for each new item
      updatedNewItems.forEach((item) => {
        const notification = new Notification('New Item Added', {
          body: `New item added: ${item.name}`,
        });
      });

      newItems.value = updatedNewItems;
    })
    .catch((error) => {
      console.error('Error fetching item data:', error);
    });
};

const settingStore = useSettingStore();

document.addEventListener('DOMContentLoaded', () => {
  const toggleMenuIcon = document.getElementById('toggleMenuIcon');
  const body = document.querySelector('body');

  toggleMenuIcon.addEventListener('click', () => {
    if (body.classList.contains('sidebar-collapse')) {
      localStorage.setItem('sidebarState', 'expanded');
    } else {
      localStorage.setItem('sidebarState', 'collapsed');
    }
  });

  const sidebarState = localStorage.getItem('sidebarState');
  if (sidebarState === 'collapsed') {
    body.classList.add('sidebar-collapse');
  }
});

onMounted(() => {
  // Fetch initial notifications when the component is mounted
  checkForNewItemInDatabase();
});

// Call notifyNewItem to start checking for new items
notifyNewItem();
</script>
