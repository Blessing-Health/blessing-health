import { Dialog } from "quasar";

export function showErrorDialog(message = null, title = null) {
  return Dialog.create({
    title: title || "Error",
    message: message || "Unknown Error",
    color: "warning",
    html: true,
  });
}
