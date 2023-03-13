import { useAuthStore } from "src/stores/authStore.js";
export default (router) => {
  const authStore = useAuthStore();

  router.beforeEach((to, from, next) => {
    let user = authStore.user || {};

    return next();
  });
};
