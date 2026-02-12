<template>
  <!-- Match Projects page: white gutters + full-width dark gradient container -->
  <div class="min-h-screen bg-white px-[5px]">
    <div
      class="min-h-[calc(100vh-4rem)] rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 p-6 md:p-10"
    >
      <div class="min-h-[calc(100vh-8rem)] flex items-center justify-center">
        <div
          class="w-full max-w-md rounded-2xl border border-slate-800 bg-white/5 backdrop-blur p-8
                 shadow-[0_20px_60px_-30px_rgba(0,0,0,0.85)]"
        >
          <div class="text-center">
            <p class="text-xs tracking-widest text-slate-400 uppercase">Access</p>
            <h1 class="mt-2 text-2xl font-semibold text-slate-100">Welcome back</h1>
            <p class="mt-2 text-sm text-slate-400">
              Sign in to continue to StackPilot
            </p>
          </div>

          <form class="mt-6 space-y-4" @submit.prevent="submit">
            <div>
              <label class="block text-xs text-slate-400 mb-1">Email</label>
              <input
                v-model="email"
                type="email"
                required
                class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100
                       placeholder:text-slate-500 outline-none transition
                       focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                placeholder="demo@stackpilot.test"
                :disabled="auth.loading"
              />
            </div>

            <div>
              <label class="block text-xs text-slate-400 mb-1">Password</label>
              <input
                v-model="password"
                type="password"
                required
                class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100
                       placeholder:text-slate-500 outline-none transition
                       focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                placeholder="password"
                :disabled="auth.loading"
              />
            </div>

            <button
              class="w-full rounded-xl bg-amber-500 px-5 py-3 font-medium text-slate-950 transition
                     hover:bg-amber-400 active:bg-amber-500 disabled:opacity-60 disabled:hover:bg-amber-500"
              :disabled="auth.loading"
            >
              {{ auth.loading ? "Signing in..." : "Login" }}
            </button>

            <p v-if="auth.error" class="text-sm text-rose-300 text-center">
              {{ auth.error }}
            </p>
          </form>

          <div class="mt-6 text-center text-xs text-slate-500">
            Tip: use <span class="text-slate-300">demo@stackpilot.test</span> /
            <span class="text-slate-300">password</span>
          </div>
        </div>
      </div>
    </div>
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
  if (!auth.error) {
    router.push("/");
  }
}
</script>
