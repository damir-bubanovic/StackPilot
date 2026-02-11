<template>
  <div class="space-y-6">
    <!-- Create Project -->
    <div class="bg-white border rounded p-6">
      <h1 class="text-xl font-semibold">Projects</h1>

      <form class="mt-4 grid gap-3" @submit.prevent="createProject">
        <input v-model="name" class="border p-2 rounded" placeholder="Project name" required />
        <button class="bg-black text-white px-4 py-2 rounded">Create Project</button>
      </form>
    </div>

    <!-- Projects -->
    <div v-for="p in projects.items" :key="p.id" class="bg-white border rounded p-6">
      <div class="flex justify-between items-center">
        <h2 class="font-semibold">{{ p.name }}</h2>
        <button class="border px-3 py-1 rounded" @click="deleteProject(p.id)">Delete</button>
      </div>

      <!-- Tasks -->
      <div class="mt-4">
        <input
          v-model="taskTitle"
          placeholder="New task..."
          class="border p-2 w-full mb-2"
          @keyup.enter="addTask(p.id)"
        />

        <div v-for="t in tasks.items" :key="t.id" class="flex justify-between py-1">
          <label>
            <input type="checkbox" :checked="t.status === 'done'" @change="toggleTask(t)" />
            <span :class="{ 'line-through text-gray-400': t.status === 'done' }">
              {{ t.title }}
            </span>
          </label>

          <button @click="deleteTask(t.id)" class="text-sm text-red-600">x</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useProjectsStore } from "../stores/projects";
import { useTasksStore } from "../stores/tasks";

const projects = useProjectsStore();
const tasks = useTasksStore();

const name = ref("");
const taskTitle = ref("");

onMounted(async () => {
  await projects.fetchAll();
});

async function createProject() {
  await projects.create({ name: name.value });
  name.value = "";
}

async function deleteProject(id) {
  await projects.remove(id);
}

async function addTask(projectId) {
  await tasks.fetch(projectId);
  await tasks.create(taskTitle.value);
  taskTitle.value = "";
}

async function toggleTask(task) {
  await tasks.toggle(task);
}

async function deleteTask(id) {
  await tasks.remove(id);
}
</script>
