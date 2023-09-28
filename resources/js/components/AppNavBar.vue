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
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ totalCount }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">{{ totalCount }} Notifications</span>
          <div class="dropdown-divider"></div>
          <li v-for="item in itemNames" :key="item.id">
            <a href="#" class="dropdown-item">{{ item.name }}</a>
          </li>
          <div class="dropdown-divider"></div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link"  role="button" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-sticky-note"></i>
         </a>
      </li>
    </ul>
  </nav>
  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
     <div class="modal-dialog modal-dialog mr-2 mt-2 custom-modal" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModal"><img src="https://cdn-icons-png.flaticon.com/512/6797/6797273.png" alt="" width="25" height="25" class="mr-1 mb-1"/>
              Notes
           </h5>
          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form  @submit.prevent="createNote()">
            <div class="form-group">
                  <textarea v-model="form.notes" class="form-control" id="description" rows="3" :class="{ 'is-invalid': errors.notes}"
                    placeholder="Add some notes ..."></textarea>
                    <span v-if="errors && errors.notes" class="text-danger text-sm">{{ errors.notes[0]}}</span>
                    <button type="submit" class="btn btn-primary btn-sm float-right mt-1"><i class="fa fa-save mr-2"></i>Save</button>
            </div>

              <div v-if="notes.length > 0" class="mt-5">
                 <div v-for="note in notes" :key="note.id" class="container darker">
                   <router-link to="" @click.prevent="deleteNotes(note.id)">
                      <i class="fa fa-times text-red float-right"></i>
                    </router-link>
                    
                   <img :src="note.userAvatar" alt="User Avatar" style="height: 55px; width: 50px  " >

                   <div class="d-flex justify-content-between">
                        <p class="small mb-1">{{ note.userName }}</p>
                        <p class="small mb-1 text-muted mr-2">{{ timeDate(note.date) }}</p>
                   </div>

                   <div class="card">
                        <div class="card-body">
                          <p class="card-text">{{ note.notes }} </p>
                        </div>
                      </div>
                  </div>
                </div>

              <div v-else>
                <p class="text-danger">No notes available !</p>
              </div>

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
import Swal from 'sweetalert2';
import { timeDate } from './../helper.js';
import { useAuthUserStore } from '../store/themeStore.js';

const authUserStore = useAuthUserStore();

const form = ref({
  notes: '',
});
const errors = ref([]);
const toastr = useToastr();
const notes = ref([]); 

const createNote = () => {
  axios.post('/notes', form.value)
    .then((response) => {
      toastr.success('Note created successfully!');
      clearForm();
      getNotes();
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
const getNotes = () => {
  axios.get('/notes/data')
    .then((response) => {
      const notesData = response.data;
      const notePromises = notesData.map(note => {
        return axios.get(`/user/${note.user_id}`)  
          .then(userResponse => ({
            id: note.id,
            notes: note.notes,
            date: note.date,
            userName: userResponse.data.name,
            userAvatar: userResponse.data.avatar 
          }))
          .catch(error => {
            console.error('Error fetching user:', error);
            return null;
          });
      });

      Promise.all(notePromises)
        .then(notesWithUser => {
          notes.value = notesWithUser.filter(note => note !== null);
        });
    })
    .catch((error) => {
      console.error('Error fetching all items:', error);
    });
};

const deleteNotes = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/notes/${id}`)
            .then(() => {
                notes.value = notes.value.filter(note => note.id !== id);

                Swal.fire(
                    'Deleted!',
                    'Notes has been deleted.',
                    'success'
                );
               
                getNotes();
            })
            .catch((error) => {
                console.error('Error deleting notes:', error);
            });
        }
    });
};

const itemNames = ref([]);
const totalCount = ref(0);

const fetchItemNamesAndCount = () => {
  axios.get('/notification')
    .then((response) => {
      itemNames.value = response.data.itemNames;
      totalCount.value = response.data.totalCount;
    })
    .catch((error) => {
      console.error('Error fetching item names and count:', error);
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
getNotes();
fetchItemNamesAndCount();
 });

</script>
<style scoped>
.custom-modal {
  max-height: 100vh; 
  overflow-y: auto;
}
.custom-modal .modal-body {
  max-height: calc(100vh - 120px);
  overflow-y: auto; 
}
.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}
.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
} 
</style>