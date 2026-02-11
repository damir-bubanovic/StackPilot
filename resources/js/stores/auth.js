import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
    token: localStorage.getItem("token"),
    loading: false,
    error: null,
  }),

  actions: {
    client() {
      const c = axios.create({
        headers: {
          Accept: "application/json",
        },
      });

      if (this.token) {
        c.defaults.headers.common.Authorization = `Bearer ${this.token}`;
      }

      return c;
    },

    async login(email, password) {
      this.loading = true;
      this.error = null;

      try {
        const res = await this.client().post("/api/v1/auth/login", {
          email,
          password,
        });

        this.token = res.data.data.token;
        localStorage.setItem("token", this.token);
        this.user = res.data.data.user;
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Login failed";
        throw e;
      } finally {
        this.loading = false;
      }
    },

    async register(name, email, password) {
      this.loading = true;
      this.error = null;

      try {
        const res = await this.client().post("/api/v1/auth/register", {
          name,
          email,
          password,
        });

        this.token = res.data.data.token;
        localStorage.setItem("token", this.token);
        this.user = res.data.data.user;
      } catch (e) {
        this.error = e?.response?.data?.message ?? "Registration failed";
        throw e;
      } finally {
        this.loading = false;
      }
    },

    async fetchMe() {
      if (!this.token) return;

      try {
        const res = await this.client().get("/api/v1/me");
        this.user = res.data.data;
      } catch {
        this.user = null;
        this.token = null;
        localStorage.removeItem("token");
      }
    },

    async logout() {
      try {
        await this.client().post("/api/v1/auth/logout");
      } finally {
        this.user = null;
        this.token = null;
        localStorage.removeItem("token");
      }
    },
  },
});
