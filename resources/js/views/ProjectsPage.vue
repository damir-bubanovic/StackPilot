<template>
  <!-- White gutters (5px) + full-width page -->
  <div class="min-h-screen bg-white px-[5px]">
    <!-- Full-width dark container -->
    <div
      class="min-h-[calc(100vh-4rem)] rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 p-6 md:p-10"
    >
      <!-- Header -->
      <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
        <div>
          <p class="text-xs tracking-widest text-slate-400 uppercase">Workspace</p>
          <h1 class="mt-1 text-2xl md:text-3xl font-semibold text-slate-100">
            Projects
            <span class="text-amber-400">·</span>
            <span class="text-slate-400 font-medium">Tasks</span>
          </h1>
          <p class="mt-2 text-sm text-slate-400 max-w-2xl">
            Create projects and manage tasks per project. Everything is scoped to your account.
          </p>
        </div>

        <div class="mt-4 md:mt-0 flex items-center gap-2 text-xs text-slate-400">
          <span class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-white/5 px-3 py-1">
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            Accent: Amber
          </span>
          <span class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-white/5 px-3 py-1">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            Secondary: Emerald
          </span>
        </div>
      </div>

      <!-- Create Project -->
      <div
        class="mt-8 rounded-2xl border border-slate-800 bg-white/5 backdrop-blur p-6 shadow-[0_20px_60px_-30px_rgba(0,0,0,0.8)]"
      >
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 class="text-lg font-semibold text-slate-100">Create a project</h2>
            <p class="mt-1 text-sm text-slate-400">Give it a clear name. You can add tasks right after.</p>
          </div>

          <div class="hidden md:flex items-center gap-2">
            <span
              class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-amber-500/15 border border-amber-500/30 text-amber-300"
            >
              +
            </span>
            <span class="text-xs text-slate-400">Quick create</span>
          </div>
        </div>

        <form class="mt-5 grid gap-3 md:grid-cols-[1fr_auto]" @submit.prevent="createProject">
          <div>
            <input
              v-model="name"
              class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition
                     focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
              placeholder="Project name (e.g. Marketing site)"
              required
              :disabled="projects.loading"
            />
            <p v-if="projects.error" class="mt-2 text-sm text-rose-300">
              {{ projects.error }}
            </p>
          </div>

          <button
            class="rounded-xl bg-amber-500 px-5 py-3 font-medium text-slate-950 transition
                   hover:bg-amber-400 active:bg-amber-500 disabled:opacity-60 disabled:hover:bg-amber-500"
            :disabled="projects.loading"
          >
            {{ projects.loading ? "Working..." : "Create" }}
          </button>
        </form>
      </div>

      <!-- Loading / empty states -->
      <div class="mt-6">
        <div v-if="projects.loading" class="text-sm text-slate-400">
          Loading projects...
        </div>

        <div
          v-else-if="projects.items.length === 0"
          class="rounded-2xl border border-slate-800 bg-white/5 backdrop-blur p-6 text-sm text-slate-400"
        >
          No projects yet. Create one above.
        </div>
      </div>

      <!-- Projects grid -->
      <div v-if="!projects.loading && projects.items.length" class="mt-6 grid gap-6 lg:grid-cols-2">
        <div
          v-for="p in projects.items"
          :key="p.id"
          class="group rounded-2xl border border-slate-800 bg-white/5 backdrop-blur p-6
                 shadow-[0_20px_60px_-30px_rgba(0,0,0,0.85)]
                 transition hover:border-slate-700"
        >
          <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
              <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-400/90"></span>
                <h2 class="truncate text-base font-semibold text-slate-100">
                  {{ p.name }}
                </h2>
              </div>
              <p class="mt-1 text-xs text-slate-500">Project ID: {{ p.id }}</p>
            </div>

            <button
              class="rounded-xl border border-slate-700 bg-slate-950/30 px-3 py-2 text-sm text-slate-200 transition
                     hover:border-rose-500/40 hover:text-rose-200 disabled:opacity-60"
              :disabled="projects.loading"
              @click="deleteProject(p.id)"
            >
              Delete
            </button>
          </div>

          <!-- Tasks -->
          <div class="mt-5 border-t border-slate-800 pt-5">
            <div class="flex items-center gap-2">
              <input
                v-model="taskTitleByProject[p.id]"
                placeholder="Add a task…"
                class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition
                       focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                :disabled="tasks.loading"
                @focus="ensureTasksLoaded(p.id)"
                @keyup.enter="addTask(p.id)"
              />

              <button
                class="shrink-0 rounded-xl bg-amber-500/15 border border-amber-500/30 px-4 py-3 text-sm font-medium text-amber-200 transition
                       hover:bg-amber-500/20 disabled:opacity-60"
                :disabled="tasks.loading"
                @click.prevent="addTask(p.id)"
                title="Add task"
              >
                +
              </button>
            </div>

            <div v-if="tasks.loading" class="mt-3 text-sm text-slate-400">
              Loading tasks...
            </div>

            <div class="mt-3 space-y-2">
              <div
                v-for="t in (tasks.byProject[p.id] || [])"
                :key="t.id"
                class="flex items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950/30 px-3 py-2"
              >
                <label class="flex min-w-0 items-center gap-3">
                  <input
                    type="checkbox"
                    class="h-4 w-4 accent-amber-500"
                    :checked="t.status === 'done'"
                    @change="toggleTask(t)"
                  />
                  <span
                    class="truncate text-sm"
                    :class="t.status === 'done' ? 'text-slate-500 line-through' : 'text-slate-100'"
                  >
                    {{ t.title }}
                  </span>
                </label>

                <button
                  class="text-xs text-rose-300/90 hover:text-rose-200 disabled:opacity-60"
                  :disabled="tasks.loading"
                  @click="deleteTask(p.id, t.id)"
                  title="Delete task"
                >
                  ✕
                </button>
              </div>

              <div
                v-if="tasks.byProject[p.id] && tasks.byProject[p.id].length === 0"
                class="text-sm text-slate-500"
              >
                No tasks yet.
              </div>

              <p v-if="tasks.error" class="text-sm text-rose-300 mt-2">
                {{ tasks.error }}
              </p>
            </div>
          </div>
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
const taskTitleByProject = ref({});

onMounted(async () => {
  await projects.fetchAll();
});

async function createProject() {
  const trimmed = name.value.trim();
  if (!trimmed) return;

  await projects.create({ name: trimmed });
  name.value = "";
}

async function deleteProject(id) {
  if (!confirm("Delete this project?")) return;

  await projects.remove(id);
  delete tasks.byProject[id];
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
