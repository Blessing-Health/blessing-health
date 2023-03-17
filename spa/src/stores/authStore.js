import { defineStore } from "pinia";
import { post } from "src/utils/resources";
import { appUrl } from "src/consts.js";

export const useAuthStore = defineStore("auth", {
  state: () => ({
    user: null,
  }),
  getters: {
    isLoggedIn: (state) => !!state.user,
  },
  actions: {
    async login(form) {
      // this.user = await post(`${appUrl}/login`, form);
    },
    async logout() {
      await post(`${appUrl}/logout`).catch(() => {});
    },
  },
  persist: true,
});
