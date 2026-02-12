<template>
  <!-- Match Projects/Login: white gutters + full-width dark gradient container -->
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
            <p class="text-xs tracking-widest text-slate-400 uppercase">Create account</p>
            <h1 class="mt-2 text-2xl font-semibold text-slate-100">Get started</h1>
            <p class="mt-2 text-sm text-slate-400">
              Create your StackPilot account to manage projects and tasks.
            </p>
          </div>

          <form class="mt-6 space-y-4" @submit.prevent="submit">
            <div>
              <label class="block text-xs text-slate-400 mb-1">Name</label>
              <input
                v-model="name"
                type="text"
                required
                class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100
                       placeholder:text-slate-500 outline-none transition
                       focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                placeholder="John Doe"
                :disabled="auth.loading"
              />
            </div>

            <div>
              <label class="block text-xs text-slate-400 mb-1">Email</label>
              <input
                v-model="email"
                type="email"
                required
                class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100
                       placeholder:text-slate-500 outline-none transition
                       focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                placeholder="you@example.com"
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
                placeholder="Create a password"
                :disabled="auth.loading"
              />
            </div>

            <button
              class="w-full rounded-xl bg-amber-500 px-5 py-3 font-medium text-slate-950 transition
                     hover:bg-amber-400 active:bg-amber-500 disabled:opacity-60 disabled:hover:bg-amber-500"
              :disabled="auth.loading"
            >
              {{ auth.loading ? "Creating..." : "Register" }}
            </button>

            <p v-if="auth.error" class="text-sm text-rose-300 text-center">
              {{ auth.error }}
            </p>
          </form>

          <div class="mt-6 text-center text-xs text-slate-500">
            Already have an account?
            <RouterLink to="/login" class="text-amber-300 hover:text-amber-200 underline">
              Login
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter, RouterLink } from "vue-router";
import { useAuthStore } from "../stores/auth";

const name = ref("");
const email = ref("");
const password = ref("");

const auth = useAuthStore();
const router = useRouter();

async function submit() {
  await auth.register(name.value, email.value, password.value);
  if (!auth.error) {
    router.push("/");
  }
}
</script>
