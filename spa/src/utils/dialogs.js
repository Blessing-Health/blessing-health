import { Dialog } from "quasar";
import errors from "src/lang/en/errors.js";

export function showErrorDialog(message = null, title = null) {
  return Dialog.create({
    title: title || errors.whoops,
    message: message || errors.unknownError,
    color: "warning",
    html: true,
    noRouteDismiss: true,
    noFocus: true,
    actions: [{ label: "Dismiss", color: "white" }],
  });
}

// Get the user to confirm an action
export function confirmAction(message, title, color = "info") {
  let dialog = Dialog.create({
    title,
    message,
    cancel: true,
    color,
    noFocus: true,
    ok: { label: "Proceed" },
  });

  return new Promise((resolve, reject) => {
    dialog.onOk(() => resolve(true)).onCancel(() => reject(errors.userAbort));
  });
}

// Generic yes/no confirm dialog
export function confirmYesNo(message, title, opts = {}) {
  let dialog = Dialog.create({
    title,
    message,
    noFocus: true,
    ok: { label: "Yes", color: "primary" },
    cancel: { label: "No", flat: true },
    ...opts,
  });

  return new Promise((resolve) => {
    dialog.onOk(() => resolve(true)).onCancel(() => resolve(false));
  });
}

// Show a dialog asking user whether they want to discard their form
export function confirmFormLeave(hasUnsavedChanges, next) {
  console.log(2);
  // if (!hasUnsavedChanges) return next();
  // let dialog = Dialog.create({
  //   title: errors.unsavedChanges.title,
  //   message: errors.unsavedChanges.message,
  //   cancel: true,
  //   noFocus: true,
  //   color: "negative",
  //   ok: { label: "Discard Changes" },
  // });
  // dialog.onOk(() => next()).onCancel(() => next(false));
}
