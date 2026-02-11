<template>
  <div class="space-y-6">
    <!-- Create Project -->
    <div class="bg-white border rounded p-6">
      <h1 class="text-xl font-semibold">Projects</h1>

      <form class="mt-4 grid gap-3" @submit.prevent="createProject">
        <input
          v-model="name"
          class="border p-2 rounded"
          placeholder="Project name"
          required
        />
        <button class="bg-black text-white px-4 py-2 rounded">
          Create Project
        </button>
      </form>
    </div>

    <!-- Projects -->
    <div
      v-for="p in projects.items"
      :key="p.id"
      class="bg-white border rounded p-6"
    >
      <div class="flex justify-between items-center">
        <h2 class="font-semibold">{{ p.name }}</h2>
        <button class="border px-3 py-1 rounded" @click="deleteProject(p.id)">
          Delete
        </button>
      </div>

      <!-- Tasks -->
      <div class="mt-4">
        <input
          v-model="taskTitleByProject[p.id]"
          placeholder="New task..."
          class="border p-2 w-full mb-2"
          @focus="ensureTasksLoaded(p.id)"
          @keyup.enter="addTask(p.id)"
        />

        <div v-if="tasks.loading" class="text-sm text-gray-600">
          Loading tasks...
        </div>

        <div
          v-for="t in (tasks.byProject[p.id] || [])"
          :key="t.id"
          class="flex justify-between py-1"
        >
          <label class="flex items-center gap-2">
            <input
              type="checkbox"
              :checked="t.status === 'done'"
              @change="toggleTask(t)"
            />
            <span :class="{ 'line-through text-gray-400': t.status === 'done' }">
              {{ t.title }}
            </span>
          </label>

          <button
            @click="deleteTask(p.id, t.id)"
            class="text-sm text-red-600"
            title="Delete task"
          >
            x
          </button>
        </div>

        <div
          v-if="(tasks.byProject[p.id] || []).length === 0"
          class="text-sm text-gray-600"
        >
          No tasks yet.
        </div>

        <p v-if="tasks.error" class="text-sm text-red-600 mt-2">
          {{ tasks.error }}
        </p>
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
const taskTitleByProject = ref({});

onMounted(async () => {
  await projects.fetchAll();
});

async function createProject() {
  await projects.create({ name: name.value });
  name.value = "";
}

async function deleteProject(id) {
  if (!confirm("Delete this project?")) return;

  await projects.remove(id);
  delete tasks.byProject[id]; // clear tasks cache for that project
  delete taskTitleByProject.value[id];
}

async function ensureTasksLoaded(projectId) {
  if (!tasks.byProject[projectId]) {
    await tasks.fetch(projectId);
  }
}

async function addTask(projectId) {
  const title = (taskTitleByProject.value[projectId] || "").trim();
  if (!title) return;

  await ensureTasksLoaded(projectId);
  await tasks.create(projectId, title);

  taskTitleByProject.value[projectId] = "";
}

async function toggleTask(task) {
  await tasks.toggle(task);
}

async function deleteTask(projectId, taskId) {
  if (!confirm("Delete this task?")) return;
  await tasks.remove(projectId, taskId);
}
</script>
