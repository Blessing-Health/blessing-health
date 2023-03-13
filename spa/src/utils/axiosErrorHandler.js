import { showErrorDialog as showDefaultErrorDialog } from "./dailogs.js";
import { flatMap, uniq } from "lodash-es";
import { appUrl } from "src/consts.js";
import { useAuthStore } from "src/stores/authStore.js";
/**
 * Global error handler for exios
 */
let isHandlingError = false;
const LARAVEL_DEFAULT_403 = "The action is unauthorized";
const LARAVEL_DEFAULT_500 = "Server Error";

export default function axiosErrorHandler(error, rethrow = true) {
  if (!error.isAxiosError) throw error;
  if (!isHandlingError) {
    isHandlingError = true;

    if (!error || !error.response) {
      showErrorDialog();
    } else {
      handleHttpStatusCodeError(error);
    }
  }
}

const showErrorDialog = (message, title) => {
  return showDefaultErrorDialog(
    message || "Unable to communcicate with server",
    title || "Whoops"
  ).onDismiss(() => (isHandlingError = false));
};

const handleHttpStatusCodeError = (error) => {
  const { status, data } = error.response;
  switch (status) {
    case 0:
      return;
    case 401:
      return handleUnauthenticatedError();
    case 422:
      return showErrorDialog(
        uniq(flatMap(data.errors, (messages) => messages)).join("<br>") ||
          data.message ||
          "errors.validation.message"
      );
    case 403:
      return showErrorDialog(
        data.message && data.message != LARAVEL_DEFAULT_403
          ? data.message
          : "errors.forbidden.message",
        "errors.forbidden.title"
      );
    case 404:
      return showErrorDialog(
        "errors.not_found.message",
        "errors.not_found.title"
      );
    case 500:
      return showErrorDialog(
        data.message !== LARAVEL_DEFAULT_500
          ? data.message
          : "errors.server_error.message",
        "errors.server_error.title"
      );
    case 502:
    case 503:
    case 504:
      return showErrorDialog(
        "errors.server_unavailable.message",
        "errors.server_unavailable.title"
      );
    default:
      return showErrorDialog();
  }
};

const handleUnauthenticatedError = async () => {
  useAuthStore().logout();

  let dialog = await showErrorDialog(
    "Whoops! Email or mobile or password is incorrect. Please try again",
    "Unauthenticated"
  );

  dialog.onOk(() => {});
};
