import { defineStore } from "pinia";
import { appName } from "src/consts.js";
export const useAppStore = defineStore("app", {
  state: () => ({
    sidebarIsOpen: false,
    isLoading: true,
    isFillingOutForm: false,
    // Page metadata - you should call setPageInfo on every new page
    page: {
      title: "Untitled Page",
      section: "Untitled Section",
      subtitle: "No page subtitle has been specified",
      icon: "help_outline",
      breadcrumbs: [], // Array of objects in the format expected by q-breadcrumbs-el (specific to each page)
      officeId: null, // Whether the current page is "scoped" to the given office ID (can be set to 'auto' to default to my selected office)
      hasCustomSubtitle: false, // Prevents appending some default wording to the given subtitle
    },
  }),

  getters: {},

  actions: {
    toggleSidebar() {
      this.sidebarIsOpen = !this.sidebarIsOpen;
    },
    setLoading(isLoading) {
      this.isLoading = isLoading;
    },
    setPageInfo(pageConfig) {
      this.page = {
        breadcrumbs: [],
        ...pageConfig,
      };

      document.title = pageConfig.title
        ? `${pageConfig.title} • ${appName}`
        : appName;
    },
    setIsFillingOutForm(isFillingOutForm) {
      this.isFillingOutForm = isFillingOutForm;
    },
  },
});
