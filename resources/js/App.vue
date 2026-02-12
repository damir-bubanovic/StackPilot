<template>
  <!-- White page with 5px gutters -->
  <div class="min-h-screen bg-white px-[5px] flex flex-col">
    <!-- Header -->
    <nav class="border-b bg-white">
      <div class="px-4 py-3 flex justify-between items-center">
        <div class="flex items-center gap-2 font-semibold">
          <img :src="logoUrl" alt="StackPilot" class="h-8 w-8" />
          <span>StackPilot</span>
        </div>

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

    <!-- Main content -->
    <main class="flex-1 p-4">
      <RouterView />
    </main>

    <!-- Footer -->
    <footer class="border-t bg-white">
      <div class="px-4 py-3 text-center text-sm text-black">
        © {{ year }} ·
        <a href="mailto:damir.bubanovic@yahoo.com" class="underline">
          damir.bubanovic@yahoo.com
        </a>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { RouterView, RouterLink, useRouter } from "vue-router";
import { useAuthStore } from "./stores/auth";

const auth = useAuthStore();
const router = useRouter();

const logoUrl = computed(() => new URL("/public/images/logo.svg", import.meta.url).href);
const year = new Date().getFullYear();

async function logout() {
  await auth.logout();
  router.push("/login");
}
</script>
