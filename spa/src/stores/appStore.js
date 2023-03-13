import { defineStore } from "pinia";

export const useAppStore = defineStore("app", {
  state: () => ({
    sidebarIsOpen: false,
  }),

  getters: {},

  actions: {
    toggleSidebar() {
      this.sidebarIsOpen = !this.sidebarIsOpen;
    },
  },
});
