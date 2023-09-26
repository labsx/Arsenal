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
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" @click="clearNewItems">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">
            {{ totalAddedItems }}
          </span>
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
      </li> -->

                <li class="nav-item">
                    <a class="nav-link"  role="button" data-toggle="modal" data-target="#exampleModal">
                      <i class="fa fa-sticky-note"></i>
                    </a>
                </li>
    </ul>
  </nav>
  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog mr-2 mt-2 " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModal"><img src="https://cdn-icons-png.flaticon.com/512/6797/6797273.png" alt="" width="25" height="25" class="mr-1 mb-1"/> Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  @submit.prevent="createNote()">
            <div class="form-group">
                <label for="description"></label>
                  <textarea v-model="form.notes" class="form-control" id="description" rows="3" :class="{ 'is-invalid': errors.notes}"
                    placeholder="Add some notes ..."></textarea>
                    <span v-if="errors && errors.notes" class="text-danger text-sm">{{ errors.notes[0]}}</span>
            </div>
            <button type="submit" class="btn btn-primary btn-sm float-right"><i class="fa fa-save mr-2"></i>Save</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useSettingStore } from '../store/themeStore.js';
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';
import { useToastr } from './../toastr';

const form = ref({
  notes: '',
});
const errors = ref([]);
const toastr = useToastr();

const createNote = () => {
  axios.post('/notes', form.value)
    .then((response) => {
      toastr.success('Note created successfully!');
      clearForm();
    })
    .catch((error) => {
      if (error.response && error.response.status === 400) {
        toastr.error('Error: Bad request. Note could not be created.');
      } else if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        clearForm();
      } else {
        toastr.error('An unexpected error occurred. Please try again later.');
      }
    });
};
const clearForm = () => {
  form.value.notes = '';
};

// const newItems = ref([]);
// const addedItems = ref({});
// const totalAddedItems = ref(0);

// let itemCountsMap = new Map();

// const clearNewItems = () => {
//   totalAddedItems.value = 0;
//   for (const itemName of itemCountsMap.keys()) {
//     localStorage.setItem(`itemCount_${itemName}`, 0);
//   }
//   newItems.value = [];
// };

// const notifyNewItem = () => {
//   totalAddedItems.value = 0;
//   for (const itemName of itemCountsMap.keys()) {
//     localStorage.setItem(`itemCount_${itemName}`, 0);
//   }

//   setInterval(() => {
//     checkForNewItemInDatabase();
//   }, 1000);

//   checkForNewItemInDatabase();
// };

// const checkForNewItemInDatabase = () => {
//   axios
//     .get("/notification")
//     .then((response) => {
//       const itemNames = response.data.itemNames;
//       const updatedNewItems = itemNames.map((name) => {
//         const lastCount = parseInt(localStorage.getItem(`itemCount_${name}`)) || 0;
//         const count = lastCount + 1;
//         localStorage.setItem(`itemCount_${name}`, count);
//         return { name, count };
//       });

//       totalAddedItems.value = updatedNewItems.length;

//       updatedNewItems.forEach((item) => {
//         const notification = new Notification('New Item Added', {
//           body: `New item added: ${item.name}`,
//         });
//       });

//       newItems.value = updatedNewItems;
//     })
//     .catch((error) => {
//       console.error('Error fetching item data:', error);
//     });
// };

// const handleNotificationClick = () => {
//   clearNewItems();
//   notifyNewItem();
// };

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

// onMounted(() => {
//   checkForNewItemInDatabase();
// });
// notifyNewItem();
</script>
