<template>
    <div class="wrapper">
    <main>
      <section>
        <div class="face" @mousemove="onMouseMove($event)">
          <img src="https://assets.codepen.io/9277864/PF.png" alt="Face" widht="250" height="250" />
          <div class="eye-cover1">
            <div id="eyes1"></div>
          </div>

          <div class="eye-cover2">
            <div id="eyes2"></div>
          </div>
        </div>
        <div class="login-container" @mousemove="onMouseMove($event)">
          <div class="social-login">
            <div class="logo">
             <img  src="//5.imimg.com/data5/DJ/TC/BR/SELLER-8938681/inventory-management-software-500x500.png" width="200" height="200" >
          </div>
            <div class="social-grp">
             <p>Data</p>
              <div class="btn"><a><img src="https://symbols.getvecta.com/stencil_68/10_boy-clean.2f0b8a28e3.svg" alt="" width="32" height="32" /><span>Profile</span></a></div>
              <div class="btn"><a><img src="https://cdn-icons-png.flaticon.com/512/6797/6797273.png" alt="" width="45" height="32" /><span>Data</span></a></div>
            </div>
          </div>
          <div class="email-login">
            <div class="login-h-container">
              <h1>Login to your account</h1>
            </div>
            <form @submit.prevent="handleSubmit">
              <label for="email">
                <input v-model="form.email" id="email" name="email" type="email" placeholder="" autocomplete="off">
                <span id="span-email">Email</span>
              </label>
              <label for="password">
                <input v-model="form.password" id="password" name="password" type="password" placeholder="">
                <span id="span-password">Password</span>
              </label>
              <input type="submit" value="Login" class="text-secondary">
            </form>
             <div v-if="errorMessage" class="alert alert-danger " role="alert">
                <p class="text-center">{{ errorMessage }}</p>
            </div>
          </div>
        </div>
      </section>
        <div class="vector-1"></div>
        <div class="vector-2"></div>
        <div class="vector-3"></div>
    </main>
    <div class="codepen-footer">
      <small>Login your account</small>
    </div>
  </div>
</template>
<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
 import { useAuthUserStore } from '../../store/themeStore';

 const authUserStore = useAuthUserStore();
const router = useRouter();
const errorMessage = ref('');
const form = reactive({
    email: '',
    password: '',
});

const handleSubmit = () => {
    if (!form.email.trim() || !form.password.trim()) {
        errorMessage.value = " Email and password required.";
        return; 
    }
    axios.post('/login', form)
    .then(() => {
      router.push('/admin/dashboard');
    })
    .catch((error) => {
        errorMessage.value = error.response.data.message;
         setTimeout(() => {
            errorMessage.value = '';
        }, 2000);
    });
};

const getCursorPosition = (event) => {
  const x = (event.clientX * 100) / window.innerWidth + '%';
  const y = (event.clientY * 100) / window.innerHeight + '%';

  const eyes1 = document.getElementById('eyes1');
  const eyes2 = document.getElementById('eyes2');

  eyes1.style.left = x;
  eyes1.style.top = y;
  eyes1.style.transform = `translate(-${x}, -${y})`;

  eyes2.style.left = x;
  eyes2.style.top = y;
  eyes2.style.transform = `translate(-${x}, -${y})`;
};

const onMouseMove = (event) => {
  getCursorPosition(event);
};

onMounted(() => {
  const email = document.getElementById('email');
  const emailSpan = document.getElementById('span-email');
  const password = document.getElementById('password');
  const passwordSpan = document.getElementById('span-password');

  if (email) {
    email.addEventListener('input', () => {
      if (email.value) {
        emailSpan.classList.add('focus-span');
      } else {
        emailSpan.classList.remove('focus-span');
      }
    });
  }

  if (password) {
    password.addEventListener('input', () => {
      if (password.value) {
        passwordSpan.classList.add('focus-span');
      } else {
        passwordSpan.classList.remove('focus-span');
      }
    });
  }
});
</script>


<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap");
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

:root {
  --color-1: #ee7344; 
  --color-2: #74959a; 
  --color-3: #ffc85c; 
  --color-4: #ea5455; 
}

body {
  font-family: Montserrat, sans-serif;
  height: 100vh;
  font-size: 17px;
}

.wrapper {
  max-width: 960px;
  min-width: 220px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

main {
  padding: 10px 20px;
  flex: 1;
  display: flex;
  justify-content: center;
  position: relative;
}

footer {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 999;
  background-color: #232323;
  color: white;
  text-align: center;
  padding: 6px;
}

footer a {
  color: var(--color-1);
  text-decoration: none;
}

section {
  margin-top: 20px;
  margin-bottom: 160px;
}

.face {
  text-align: center;
  position: relative;
}

.eye-cover1 {
  position: absolute;
  width: 30px;
  height: 12px;
  top: 40%;
  left: 46%;
  border-radius: 30%;
}

.eye-cover2 {
  position: absolute;
  width: 26px;
  height: 13px;
  top: 40%;
  left: 52%;
  border-radius: 30%;
}

#eyes1 {
  width: 10px;
  height: 10px;
  background-color: #fff;
  position: absolute;
  border-radius: 50%;
  border: 4px solid #333;
  overflow: hidden;
  top: 25%;
  left: 35%;
}

#eyes2 {
  width: 10px;
  height: 10px;
  background-color: #fff;
  position: absolute;
  border-radius: 50%;
  border: 4px solid #333;
  overflow: hidden;
  top: 28%;
  left: 32%;
}

.login-container {
  display: flex;
  border-radius: 3px;
  box-shadow: 6px 0 15px rgba(0, 0, 0, 0.4);
}

.social-login {
  background-color: var(--color-2);
  color: #fff;
  padding: 40px;
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  gap: 30px;
  flex: 1;
  border-top-left-radius: 3px;
  border-bottom-left-radius: 3px;
}

.social-login a {
  text-decoration: none;
}

.logo {
  display: flex;
  align-items: center;
  font-size: 32px;
  font-weight: bold;
  font-family: "Unbounded", cursive;
}

.logo p {
  margin-top: 21px;
}

.btn {
  margin-bottom: 15px;
  border: 1px solid black;
  border-radius: 6px;
  box-shadow: 0.3rem 0.3rem #111827;
  background-color: var(--color-3);
  transition-duration: 0.2s;
}

.btn:hover {
  transform: scale(1.01);
  filter: brightness(90%);
}

.btn a {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 17px;
  padding: 8px 21px;
  color: #111827;
  font-weight: bold;
}

.email-login {
  flex: 2;
  padding: 40px;
}

.email-login a {
  color: blue;
  text-decoration: none;
}

.email-login a:hover {
  border-bottom: 1px solid blue;
}

.login-h-container {
  margin-top: 30px;
  margin-bottom: 20px;
}

h1 {
  margin-bottom: 5px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

input:focus {
  outline: 1px solid #ffc85c;
  transform: scale(1.005);
}

input[type="email"],
input[type="password"] {
  line-height: 2.6;
  padding: 0 10px;
  font-size: 17px;
  width: 100%;
}

input[type="submit"] {
  background-color: var(--color-4);
  padding: 10px 120px;
  color: #fff;
  font-size: 20px;
  border: 1px solid transparent;
  border-radius: 3px;
  margin-block: 30px;
  box-shadow: 0.3rem 0.3rem #111827;
  cursor: pointer;
  transition-duration: 0.2s;
}

input[type="submit"]:hover {
  transform: scale(1.007);
  filter: brightness(90%);
}

input[type="checkbox"] {
  width: 17px;
  height: 17px;
}

label {
  position: relative;
}

label span {
  transition-duration: 0.2s;
  font-size: 18px;
  color: #5a5959;
  font-weight: 600;
  position: absolute;
  left: 6px;
  top: 11px;
  padding: 4px 8px;
}

label:focus-within span,
.focus-span {
  transform: translate(0.27rem, -94%) scale(0.8);
  background-color: #fff;
}
.vector-1 {
  background-image: url("https://assets.codepen.io/9277864/8.png");
  background-size: cover;
  width: 70px;
  height: 70px;
  position: absolute;
  top: 15%;
  left: 15%;
  z-index: -1;
  opacity: 0.2;
  transform: rotate(45deg);
}

.vector-2 {
  background-image: url("https://assets.codepen.io/9277864/6.png");
  background-size: cover;
  width: 70px;
  height: 70px;
  position: absolute;
  top: 12%;
  left: 72%;
  z-index: -1;
  opacity: 0.2;
  transform: rotate(-45deg);
}

.vector-3 {
  background-image: url("https://assets.codepen.io/9277864/1.png");
  background-size: cover;
  width: 70px;
  height: 70px;
  position: absolute;
  top: 85%;
  left: 42%;
  z-index: -1;
  opacity: 0.2;
  transform: rotate(-25deg);
}

@media only screen and (max-width: 890px) {
  .eye-cover1 {
    left: 45%;
  }

  .eye-cover2 {
    left: 52.5%;
  }
}

@media only screen and (max-width: 860px) {
  input[type="submit"] {
    padding-inline: 0;
  }
}

@media only screen and (max-width: 720px) {
  .login-container {
    flex-direction: column;
  }

  .eye-cover1 {
    left: 41.2%;
  }

  .eye-cover2 {
    left: 54.5%;
  }

  .vector-3 {
    top: 89%;
  }
}

@media only screen and (max-width: 420px) {
  main {
    padding: 0;
  }

  .social-login {
    padding: 20px;
  }

  .logo {
    font-size: 28px;
  }

  .logo img {
    width: 92px;
    height: 92px;
  }

  .email-login {
    padding: 20px;
  }

  .btn a {
    padding: 8px 12px;
  }

  .eye-cover1 {
    left: 41%;
  }

  .eye-cover2 {
    left: 56%;
  }
}

.codepen-footer {
  font-family: "Patrick Hand", cursive;
  font-size: 17px;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 99;
  background-color: #232323;
  color: orange;
  text-align: center;
  height: 38px;
  font-size: 21px;
  text-align: right;
  padding: 6px 20px;
}
</style>