import { defineStore } from "pinia";
import { useAuthStore } from "./auth";

export const useTasksStore = defineStore("tasks", {
  state: () => ({
    items: [],
    loading: false,
    error: null,
    projectId: null,
  }),

  actions: {
    async fetch(projectId) {
      const auth = useAuthStore();
      this.projectId = projectId;
      this.loading = true;

      try {
        const res = await auth.client().get(`/api/v1/projects/${projectId}/tasks`);
        this.items = res.data.data;
      } finally {
        this.loading = false;
      }
    },

    async create(title) {
      const auth = useAuthStore();
      const res = await auth.client().post(`/api/v1/projects/${this.projectId}/tasks`, {
        title,
      });

      this.items.unshift(res.data.data);
    },

    async toggle(task) {
      const auth = useAuthStore();
      const res = await auth.client().patch(`/api/v1/tasks/${task.id}`);
      task.status = res.data.data.status;
    },

    async remove(taskId) {
      const auth = useAuthStore();
      await auth.client().delete(`/api/v1/tasks/${taskId}`);
      this.items = this.items.filter(t => t.id !== taskId);
    },
  },
});
