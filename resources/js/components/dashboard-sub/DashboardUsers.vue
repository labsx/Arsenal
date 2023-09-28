<template>
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Users Detail</h6>
      </div>
      <div class="card-body" style="height: 205px; overflow-y: auto">
        <table class="table align-middle mb-0 bg-white">
          <thead class="bg-light">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>
                <div class="d-flex align-items-center">
                  <img
                    :src="user.avatar"
                    class="rounded-circle"
                    alt=""
                    style="width: 45px; height: 45px"
                  />
                </div>
              </td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const users = ref([]);
const getUsersData = () => {
  axios
    .get('/dashboard/users') 
    .then((response) => {
      users.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching users:", error);
    });
};

onMounted(() => {
  getUsersData(); 
});
</script>
