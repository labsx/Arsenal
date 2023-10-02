<template>
  <div class="wrapper">
    <main>
      <section>
        <div class="face" @mousemove="onMouseMove($event)">
          <img
            src="https://assets.codepen.io/9277864/PF.png"
            alt="Face"
            widht="250"
            height="250"
          />
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
              <img
                src="//5.imimg.com/data5/DJ/TC/BR/SELLER-8938681/inventory-management-software-500x500.png"
                width="200"
                height="200"
              />
            </div>
            <div class="social-grp">
              <p>Data</p>
              <div class="btn">
                <a
                  ><img
                    src="https://symbols.getvecta.com/stencil_68/10_boy-clean.2f0b8a28e3.svg"
                    alt=""
                    width="32"
                    height="32"
                  /><span>Profile</span></a
                >
              </div>
              <div class="btn">
                <a
                  ><img
                    src="https://cdn-icons-png.flaticon.com/512/6797/6797273.png"
                    alt=""
                    width="45"
                    height="32"
                  /><span>Data</span></a
                >
              </div>
            </div>
          </div>
          <div class="email-login">
            <div class="login-h-container">
              <h1>Login to your account</h1>
            </div>
            <form @submit.prevent="handleSubmit">
              <label for="email">
                <input
                  v-model="form.email"
                  id="email"
                  name="email"
                  type="email"
                  placeholder=""
                  autocomplete="off"
                />
                <span id="span-email">Email</span>
              </label>
              <label for="password">
                <input
                  v-model="form.password"
                  id="password"
                  name="password"
                  type="password"
                  placeholder=""
                />
                <span id="span-password">Password</span>
              </label>
              <input type="submit" value="Login" class="text-secondary" />
            </form>
            <div v-if="errorMessage" class="alert alert-danger" role="alert">
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
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthUserStore } from "../../store/themeStore";

const authUserStore = useAuthUserStore();
const router = useRouter();
const errorMessage = ref("");
const form = reactive({
  email: "",
  password: "",
});

const handleSubmit = () => {
  if (!form.email.trim() || !form.password.trim()) {
    errorMessage.value = " Email and password required.";
    return;
  }
  axios
    .post("/login", form)
    .then(() => {
      router.push("/admin/dashboard");
    })
    .catch((error) => {
      errorMessage.value = error.response.data.message;
      setTimeout(() => {
        errorMessage.value = "";
      }, 2000);
    });
};

const getCursorPosition = (event) => {
  const x = (event.clientX * 100) / window.innerWidth + "%";
  const y = (event.clientY * 100) / window.innerHeight + "%";

  const eyes1 = document.getElementById("eyes1");
  const eyes2 = document.getElementById("eyes2");

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
  const email = document.getElementById("email");
  const emailSpan = document.getElementById("span-email");
  const password = document.getElementById("password");
  const passwordSpan = document.getElementById("span-password");

  if (email) {
    email.addEventListener("input", () => {
      if (email.value) {
        emailSpan.classList.add("focus-span");
      } else {
        emailSpan.classList.remove("focus-span");
      }
    });
  }

  if (password) {
    password.addEventListener("input", () => {
      if (password.value) {
        passwordSpan.classList.add("focus-span");
      } else {
        passwordSpan.classList.remove("focus-span");
      }
    });
  }
});
</script>
<style scoped>
 @import url('./resources/css/login.css');
</style>


