<template>
  <div class="max-w-md mx-auto bg-white border p-6 rounded">
    <h1 class="text-xl mb-4">Login</h1>

    <form @submit.prevent="submit">
      <input v-model="email" class="border w-full mb-3 p-2" placeholder="Email" />
      <input v-model="password" type="password" class="border w-full mb-3 p-2" placeholder="Password" />

      <button class="bg-black text-white px-4 py-2 w-full">
        Login
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../stores/auth";

const email = ref("demo@stackpilot.test");
const password = ref("password");
const auth = useAuthStore();
const router = useRouter();

async function submit() {
  await auth.login(email.value, password.value);
  router.push("/");
}
</script>
