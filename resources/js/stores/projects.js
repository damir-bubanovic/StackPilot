import { defineStore } from "pinia";
import { useAuthStore } from "./auth";

export const useProjectsStore = defineStore("projects", {
  state: () => ({
    items: [],
    loading: false,
    error: null,
    meta: null,
    links: null,
  }),

  actions: {
    async fetchAll(url = "/api/v1/projects") {
      const auth = useAuthStore();
      this.loading = true;
      this.error = null;

      try {
        const res = await auth.client().get(url);

        // Supports both:
        // 1) { data: [...] }
        // 2) Laravel paginator: { data: [...], meta: {...}, links: {...} }
        this.items = Array.isArray(res.data.data) ? res.data.data : [];
        this.meta = res.data.meta ?? null;
        this.links = res.data.links ?? null;
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

        // If pagination is enabled, best UX is to prepend locally
        // (alternatively you can re-fetch the first page)
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
