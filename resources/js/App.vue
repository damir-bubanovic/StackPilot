<template>
  <div class="min-h-screen bg-gray-50">
    <nav class="border-b bg-white">
      <div class="mx-auto max-w-5xl px-4 py-3 flex justify-between">
        <div class="font-semibold">StackPilot</div>

        <div class="text-sm space-x-3">
          <template v-if="auth.user">
            <span>{{ auth.user.email }}</span>
            <button @click="logout" class="border px-3 py-1 rounded">
              Logout
            </button>
          </template>

          <template v-else>
            <RouterLink to="/login" class="underline">Login</RouterLink>
            <RouterLink to="/register" class="underline">Register</RouterLink>
          </template>
        </div>
      </div>
    </nav>

    <main class="mx-auto max-w-5xl p-4">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { RouterView, RouterLink, useRouter } from "vue-router";
import { useAuthStore } from "./stores/auth";

const auth = useAuthStore();
const router = useRouter();

async function logout() {
  await auth.logout();
  router.push("/login");
}
</script>
