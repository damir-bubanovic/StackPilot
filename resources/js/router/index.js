import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

import ProjectsPage from "../views/ProjectsPage.vue";
import LoginPage from "../views/LoginPage.vue";
import RegisterPage from "../views/RegisterPage.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", component: ProjectsPage, meta: { requiresAuth: true } },
    { path: "/login", component: LoginPage },
    { path: "/register", component: RegisterPage },
  ],
});

router.beforeEach(async (to) => {
  const auth = useAuthStore();

  if (auth.token && !auth.user) {
    await auth.fetchMe();
  }

  if (to.meta.requiresAuth && !auth.user) {
    return "/login";
  }
});

export default router;
