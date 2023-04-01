import { boot } from "quasar/wrappers";
import { appName, localForageKeys, version } from "src/consts.js";
import { Dark } from "quasar";
import axios from "axios";
import localforage from "localforage";
import axiosErrorHandler from "src/utils/axiosErrorHandler.js";

import PageWrapper from "layouts/common/PageWrapper.vue";
import CustomInput from "components/common/CustomInput.vue";
import AddButton from "components/buttons/AddButton.vue";
import Placeholder from "components/Placeholder.vue";
import FormWrapper from "components/forms/FormWrapper.vue";
import FormSection from "components/forms/FormSection.vue";
import FormSectionTitle from "components/forms/FormSectionTitle.vue";
import FormRow from "components/forms/FormRow.vue";
import FormInput from "components/forms/FormInput.vue";
import SaveButton from "components/buttons/SaveButton.vue";
import BackButton from "components/buttons/BackButton.vue";
import dayjs from "dayjs";
// import DeleteButton from "components/buttons/DeleteButton.vue";

// "async" is optional;
// more info on params: https://v2.quasar.dev/quasar-cli/boot-files
export default boot(async ({ app, router }) => {
  localforage.config({
    name: appName,
    version: version,
  });

  configureDayJs();
  configureAxios();

  await restoreDarkMode();
  mountGlobalVueComponent(app);
});

function configureDayJs() {
  // we'll make it it available globally on the window for convenience
  window.dayjs = dayjs;
}

function configureAxios(app) {
  axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
  // axios.defaults.withCredentials = true;

  //Wire up our global axios error handler for all types of laravel api error
  axios.interceptors.response.use(null, axiosErrorHandler);
  window.axios = axios;
}

async function restoreDarkMode() {
  Dark.set(await localforage.getItem(localForageKeys.DARK_MODE));
}

function mountGlobalVueComponent(app) {
  app.component("PageWrapper", PageWrapper);
  app.component("CustomInput", CustomInput);
  app.component("AddButton", AddButton);
  app.component("Placeholder", Placeholder);
  app.component("FormWrapper", FormWrapper);
  app.component("FormSection", FormSection);
  app.component("FormSectionTitle", FormSectionTitle);
  app.component("FormRow", FormRow);
  app.component("FormInput", FormInput);
  app.component("SaveButton", SaveButton);
  app.component("BackButton", BackButton);
  // app.component("DeleteButton", DeleteButton);
}
