import { defineStore } from "pinia";
import { useAuthStore } from "./auth";

export const useTasksStore = defineStore("tasks", {
  state: () => ({
    byProject: {}, // { [projectId]: Task[] }
    loading: false,
    error: null,
  }),

  actions: {
    async fetch(projectId) {
      const auth = useAuthStore();
      this.loading = true;
      this.error = null;

      try {
        const res = await auth
          .client()
          .get(`/api/v1/projects/${projectId}/tasks`);

        this.byProject[projectId] = Array.isArray(res.data.data)
          ? res.data.data
          : [];
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Failed to load tasks";
        throw e;
      } finally {
        this.loading = false;
      }
    },

    async create(projectId, payload) {
      const auth = useAuthStore();
      this.error = null;

      try {
        if (!this.byProject[projectId]) {
          this.byProject[projectId] = [];
        }

        const body =
          typeof payload === "string"
            ? {
                title: payload,
                description: "",
                status: "todo",
                due_date: null,
              }
            : {
                title: payload?.title ?? "",
                description: payload?.description ?? "",
                status: payload?.status ?? "todo",
                due_date: payload?.due_date ?? null,
              };

        const res = await auth
          .client()
          .post(`/api/v1/projects/${projectId}/tasks`, body);

        this.byProject[projectId].unshift(res.data.data);
      } catch (e) {
        this.error =
          e?.response?.data?.message ??
          (e?.response?.status === 422
            ? "Task validation failed"
            : "Failed to create task");
        throw e;
      }
    },

    async toggle(task) {
      const auth = useAuthStore();
      this.error = null;

      try {
        const res = await auth.client().patch(`/api/v1/tasks/${task.id}`);
        task.status = res.data.data.status;
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Failed to update task";
        throw e;
      }
    },

    async remove(projectId, taskId) {
      const auth = useAuthStore();
      this.error = null;

      try {
        await auth.client().delete(`/api/v1/tasks/${taskId}`);

        if (this.byProject[projectId]) {
          this.byProject[projectId] = this.byProject[projectId].filter(
            (t) => t.id !== taskId
          );
        }
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Failed to delete task";
        throw e;
      }
    },
  },
});