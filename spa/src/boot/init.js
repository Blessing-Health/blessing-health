import { boot } from "quasar/wrappers";
import { appName, localForageKeys, version } from "src/consts.js";
import { Dark } from "quasar";
import axios from "axios";
import localforage from "localforage";
import axiosErrorHandler from "src/utils/axiosErrorHandler.js";

import PageWrapper from "layouts/common/PageWrapper.vue";
import CustomInput from "components/common/CustomInput.vue";

// "async" is optional;
// more info on params: https://v2.quasar.dev/quasar-cli/boot-files
export default boot(async ({ app, router }) => {
  localforage.config({
    name: appName,
    version: version,
  });

  configureAxios();

  await restoreDarkMode();
  mountGlobalVueComponent(app);
});

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
}
