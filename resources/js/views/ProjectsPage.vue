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
          <p class="mt-2 max-w-2xl text-sm text-slate-400">
            Create projects and manage tasks per project. Everything is scoped to your account.
          </p>
        </div>

        <div class="mt-4 flex items-center gap-2 text-xs text-slate-400 md:mt-0">
          <span
            class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-white/5 px-3 py-1"
          >
            <span class="h-2 w-2 rounded-full bg-amber-400"></span>
            Accent: Amber
          </span>
          <span
            class="inline-flex items-center gap-2 rounded-full border border-slate-800 bg-white/5 px-3 py-1"
          >
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            Secondary: Emerald
          </span>
        </div>
      </div>

      <!-- Create Project -->
      <div
        class="mt-8 rounded-2xl border border-slate-800 bg-white/5 p-6 shadow-[0_20px_60px_-30px_rgba(0,0,0,0.8)] backdrop-blur"
      >
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 class="text-lg font-semibold text-slate-100">Create a project</h2>
            <p class="mt-1 text-sm text-slate-400">
              Add a name and optional description.
            </p>
          </div>

          <div class="hidden items-center gap-2 md:flex">
            <span
              class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-amber-500/30 bg-amber-500/15 text-amber-300"
            >
              +
            </span>
            <span class="text-xs text-slate-400">Quick create</span>
          </div>
        </div>

        <form class="mt-5 grid gap-3" @submit.prevent="createProject">
          <div>
            <input
              v-model="projectForm.name"
              class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
              placeholder="Project name (e.g. Marketing site)"
              required
              :disabled="projects.loading"
            />
          </div>

          <div>
            <textarea
              v-model="projectForm.description"
              rows="3"
              class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
              placeholder="Project description (optional)"
              :disabled="projects.loading"
            ></textarea>
          </div>

          <div>
            <p v-if="projects.error" class="text-sm text-rose-300">
              {{ projects.error }}
            </p>
          </div>

          <div class="flex justify-end">
            <button
              class="rounded-xl bg-amber-500 px-5 py-3 font-medium text-slate-950 transition hover:bg-amber-400 active:bg-amber-500 disabled:opacity-60 disabled:hover:bg-amber-500"
              :disabled="projects.loading"
            >
              {{ projects.loading ? "Working..." : "Create Project" }}
            </button>
          </div>
        </form>
      </div>

      <!-- Loading / empty states -->
      <div class="mt-6">
        <div v-if="projects.loading" class="text-sm text-slate-400">
          Loading projects...
        </div>

        <div
          v-else-if="projects.items.length === 0"
          class="rounded-2xl border border-slate-800 bg-white/5 p-6 text-sm text-slate-400 backdrop-blur"
        >
          No projects yet. Create one above.
        </div>
      </div>

      <!-- Projects grid -->
      <div v-if="!projects.loading && projects.items.length" class="mt-6 grid gap-6 lg:grid-cols-2">
        <div
          v-for="p in projects.items"
          :key="p.id"
          class="group rounded-2xl border border-slate-800 bg-white/5 p-6 shadow-[0_20px_60px_-30px_rgba(0,0,0,0.85)] transition hover:border-slate-700 backdrop-blur"
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
              <p v-if="p.description" class="mt-2 text-sm leading-6 text-slate-300">
                {{ p.description }}
              </p>
            </div>

            <button
              class="rounded-xl border border-slate-700 bg-slate-950/30 px-3 py-2 text-sm text-slate-200 transition hover:border-rose-500/40 hover:text-rose-200 disabled:opacity-60"
              :disabled="projects.loading"
              @click="deleteProject(p.id)"
            >
              Delete
            </button>
          </div>

          <!-- Task Create Form -->
          <div class="mt-5 border-t border-slate-800 pt-5">
            <div class="grid gap-3">
              <input
                v-model="taskFormByProject[p.id].title"
                placeholder="Task title"
                class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                :disabled="tasks.loading"
                @focus="ensureTasksLoaded(p.id)"
                @keyup.enter="addTask(p.id)"
              />

              <textarea
                v-model="taskFormByProject[p.id].description"
                rows="2"
                placeholder="Task description (optional)"
                class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 placeholder:text-slate-500 outline-none transition focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                :disabled="tasks.loading"
              ></textarea>

              <div class="grid gap-3 md:grid-cols-3">
                <select
                  v-model="taskFormByProject[p.id].status"
                  class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 outline-none transition focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                  :disabled="tasks.loading"
                >
                  <option value="todo">Todo</option>
                  <option value="doing">Doing</option>
                  <option value="done">Done</option>
                </select>

                <input
                  v-model="taskFormByProject[p.id].due_date"
                  type="date"
                  class="w-full rounded-xl border border-slate-800 bg-slate-950/40 px-4 py-3 text-slate-100 outline-none transition focus:border-amber-500/60 focus:ring-4 focus:ring-amber-500/10 disabled:opacity-60"
                  :disabled="tasks.loading"
                />

                <button
                  class="rounded-xl border border-amber-500/30 bg-amber-500/15 px-4 py-3 text-sm font-medium text-amber-200 transition hover:bg-amber-500/20 disabled:opacity-60"
                  :disabled="tasks.loading"
                  @click.prevent="addTask(p.id)"
                >
                  Add Task
                </button>
              </div>
            </div>

            <div v-if="tasks.loading" class="mt-3 text-sm text-slate-400">
              Loading tasks...
            </div>

            <div class="mt-3 space-y-2">
              <div
                v-for="t in (tasks.byProject[p.id] || [])"
                :key="t.id"
                class="overflow-hidden rounded-xl border border-slate-800 bg-slate-950/30"
              >
                <div class="flex items-center justify-between gap-3 px-3 py-3">
                  <label class="flex min-w-0 flex-1 items-center gap-3">
                    <input
                      type="checkbox"
                      class="h-4 w-4 accent-amber-500"
                      :checked="t.status === 'done'"
                      @change="toggleTask(t)"
                    />

                    <div class="min-w-0 flex-1">
                      <div class="flex flex-wrap items-center gap-2">
                        <span
                          class="truncate text-sm font-medium"
                          :class="t.status === 'done' ? 'text-slate-500 line-through' : 'text-slate-100'"
                        >
                          {{ t.title }}
                        </span>

                        <span
                          class="inline-flex rounded-full border px-2 py-0.5 text-[11px] font-medium"
                          :class="statusBadgeClass(t.status)"
                        >
                          {{ statusLabel(t.status) }}
                        </span>

                        <span class="text-xs text-slate-400">
                          Due: {{ formatDueDate(t.due_date) }}
                        </span>
                      </div>
                    </div>
                  </label>

                  <div class="flex items-center gap-3">
                    <button
                      class="text-xs text-slate-300 transition hover:text-white"
                      @click="toggleTaskDetails(t.id)"
                    >
                      {{ isTaskExpanded(t.id) ? "Hide" : "Details" }}
                    </button>

                    <button
                      class="text-xs text-rose-300/90 hover:text-rose-200 disabled:opacity-60"
                      :disabled="tasks.loading"
                      @click="deleteTask(p.id, t.id)"
                      title="Delete task"
                    >
                      ✕
                    </button>
                  </div>
                </div>

                <div
                  v-if="isTaskExpanded(t.id)"
                  class="border-t border-slate-800 bg-slate-950/20 px-4 py-3 text-sm text-slate-300"
                >
                  <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                      <p class="text-xs uppercase tracking-wide text-slate-500">Description</p>
                      <p class="mt-1 leading-6 text-slate-200">
                        {{ t.description || "No description" }}
                      </p>
                    </div>

                    <div class="grid gap-3">
                      <div>
                        <p class="text-xs uppercase tracking-wide text-slate-500">Status</p>
                        <p class="mt-1 text-slate-200">{{ statusLabel(t.status) }}</p>
                      </div>

                      <div>
                        <p class="text-xs uppercase tracking-wide text-slate-500">Due date</p>
                        <p class="mt-1 text-slate-200">{{ formatDueDate(t.due_date) }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                v-if="tasks.byProject[p.id] && tasks.byProject[p.id].length === 0"
                class="text-sm text-slate-500"
              >
                No tasks yet.
              </div>

              <p v-if="tasks.error" class="mt-2 text-sm text-rose-300">
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

const projectForm = ref({
  name: "",
  description: "",
});

const expandedTasks = ref({});
const taskFormByProject = ref({});

onMounted(async () => {
  await projects.fetchAll();
  await Promise.all(projects.items.map((project) => tasks.fetch(project.id)));
  initializeTaskForms();
});

function initializeTaskForms() {
  for (const project of projects.items) {
    if (!taskFormByProject.value[project.id]) {
      taskFormByProject.value[project.id] = emptyTaskForm();
    }
  }
}

function emptyTaskForm() {
  return {
    title: "",
    description: "",
    status: "todo",
    due_date: "",
  };
}

function toggleTaskDetails(taskId) {
  expandedTasks.value[taskId] = !expandedTasks.value[taskId];
}

function isTaskExpanded(taskId) {
  return !!expandedTasks.value[taskId];
}

function statusLabel(status) {
  switch (status) {
    case "done":
      return "Done";
    case "doing":
      return "Doing";
    default:
      return "Todo";
  }
}

function statusBadgeClass(status) {
  switch (status) {
    case "done":
      return "border-emerald-500/30 bg-emerald-500/10 text-emerald-300";
    case "doing":
      return "border-sky-500/30 bg-sky-500/10 text-sky-300";
    default:
      return "border-amber-500/30 bg-amber-500/10 text-amber-300";
  }
}

function formatDueDate(date) {
  if (!date) return "No due date";
  return new Date(date).toLocaleDateString();
}

async function createProject() {
  const name = projectForm.value.name.trim();
  const description = projectForm.value.description.trim();

  if (!name) return;

  await projects.create({
    name,
    description,
  });

  const createdProject = projects.items[0];

  if (createdProject?.id) {
    taskFormByProject.value[createdProject.id] = emptyTaskForm();
  }

  projectForm.value = {
    name: "",
    description: "",
  };
}

async function deleteProject(id) {
  if (!confirm("Delete this project?")) return;

  await projects.remove(id);
  delete tasks.byProject[id];
  delete taskFormByProject.value[id];
}

async function ensureTasksLoaded(projectId) {
  if (!tasks.byProject[projectId]) {
    await tasks.fetch(projectId);
  }

  if (!taskFormByProject.value[projectId]) {
    taskFormByProject.value[projectId] = emptyTaskForm();
  }
}

async function addTask(projectId) {
  const form = taskFormByProject.value[projectId];

  if (!form) return;

  const title = form.title.trim();
  const description = form.description.trim();

  if (!title) return;

  await ensureTasksLoaded(projectId);

  await tasks.create(projectId, {
    title,
    description,
    status: form.status || "todo",
    due_date: form.due_date || null,
  });

  taskFormByProject.value[projectId] = emptyTaskForm();
}

async function toggleTask(task) {
  await tasks.toggle(task);
}

async function deleteTask(projectId, taskId) {
  if (!confirm("Delete this task?")) return;
  await tasks.remove(projectId, taskId);
  delete expandedTasks.value[taskId];
}
</script>