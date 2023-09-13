<template>
    <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-5"></h2>
        <div class="text-center mb-5 text-dark"></div>
        <div class="card my-5">

          <form @submit.prevent="handleSubmit" class="card-body cardbody-color p-lg-5">

            <div class="text-center">
              <img src="https://www.seekpng.com/png/detail/334-3345000_inventory-packaging-vector-logo.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
                width="200px" alt="profile">
            </div>

            <div class="mb-3">
              <input v-model="form.email" type="text" class="form-control" id="Username" aria-describedby="emailHelp"
                placeholder="User Name">
            </div>
            <div class="mb-3">
              <input v-model="form.password" type="password" class="form-control" id="password" placeholder="password">
            </div>
            <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100">Login</button></div>
 
          </form>
        </div>

      </div>
    </div>
  </div>
</template>
<script setup> 
import axios from 'axios';
import { reactive } from 'vue';

const form = reactive({
    email: '',
    password: '',
});

const handleSubmit = () => {
    axios.post('/login', form)
    .then(() => {
        window.location.href="/admin/dashboard";
    });
};
</script>
<style scoped>
.btn-color{
  background-color: #0e1c36;
  color: #fff;
  
}

.profile-image-pic{
  height: 200px;
  width: 200px;
  object-fit: cover;
}



.cardbody-color{
  background-color: #ebf2fa;
}

a{
  text-decoration: none;
}
</style>
