import { defineStore } from "pinia";
import { useAuthStore } from "./auth";

export const useProjectsStore = defineStore("projects", {
  state: () => ({
    items: [],
    loading: false,
    error: null,
  }),

  actions: {
    async fetchAll() {
      const auth = useAuthStore();
      this.loading = true;
      this.error = null;

      try {
        const res = await auth.client().get("/api/v1/projects");
        this.items = res.data.data;
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Failed to load projects";
        throw e;
      } finally {
        this.loading = false;
      }
    },

    async create(payload) {
      const auth = useAuthStore();
      this.loading = true;
      this.error = null;

      try {
        const res = await auth.client().post("/api/v1/projects", payload);
        this.items.unshift(res.data.data);
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Failed to create project";
        throw e;
      } finally {
        this.loading = false;
      }
    },

    async remove(projectId) {
      const auth = useAuthStore();
      this.error = null;

      try {
        await auth.client().delete(`/api/v1/projects/${projectId}`);
        this.items = this.items.filter((p) => p.id !== projectId);
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Failed to delete project";
        throw e;
      }
    },
  },
});
