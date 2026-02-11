<template>
  <div class="space-y-6">
    <div class="bg-white border rounded p-6">
      <h1 class="text-xl font-semibold">Projects</h1>
      <p class="mt-1 text-gray-600 text-sm">Create and manage your projects.</p>

      <form class="mt-4 grid gap-3" @submit.prevent="createProject">
        <input
          v-model="name"
          class="border rounded px-3 py-2"
          placeholder="Project name"
          required
        />
        <textarea
          v-model="description"
          class="border rounded px-3 py-2"
          placeholder="Description (optional)"
          rows="3"
        ></textarea>

        <button
          class="bg-black text-white px-4 py-2 rounded disabled:opacity-60"
          :disabled="projects.loading"
        >
          {{ projects.loading ? "Creating..." : "Create Project" }}
        </button>

        <p v-if="projects.error" class="text-sm text-red-600">
          {{ projects.error }}
        </p>
      </form>
    </div>

    <div class="bg-white border rounded p-6">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold">Your Projects</h2>
        <button class="border px-3 py-1.5 rounded" @click="reload">
          Refresh
        </button>
      </div>

      <div v-if="projects.loading" class="mt-4 text-sm text-gray-600">
        Loading...
      </div>

      <div v-else class="mt-4 space-y-3">
        <div
          v-for="p in projects.items"
          :key="p.id"
          class="border rounded p-4 flex items-start justify-between"
        >
          <div>
            <div class="font-semibold">{{ p.name }}</div>
            <div v-if="p.description" class="text-sm text-gray-600 mt-1">
              {{ p.description }}
            </div>
            <div class="text-xs text-gray-500 mt-2">
              Created: {{ formatDate(p.created_at) }}
            </div>
          </div>

          <button
            class="border px-3 py-1.5 rounded text-sm hover:bg-gray-50"
            @click="deleteProject(p.id)"
          >
            Delete
          </button>
        </div>

        <div v-if="projects.items.length === 0" class="text-sm text-gray-600">
          No projects yet.
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useProjectsStore } from "../stores/projects";

const projects = useProjectsStore();

const name = ref("");
const description = ref("");

onMounted(async () => {
  await projects.fetchAll();
});

async function reload() {
  await projects.fetchAll();
}

async function createProject() {
  await projects.create({ name: name.value, description: description.value });
  name.value = "";
  description.value = "";
}

async function deleteProject(id) {
  if (!confirm("Delete this project?")) return;
  await projects.remove(id);
}

function formatDate(iso) {
  if (!iso) return "";
  return new Date(iso).toLocaleString();
}
</script>
