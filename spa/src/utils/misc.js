import { isFunction, isObjectLike } from "lodash-es";
import { AppFile } from "src/classes/appFile";
import { AppImage } from "src/classes/appImage";

export function attachToFormData(
  valueToAttach,
  formDataKey = null,
  formData = null
) {
  if (!formData) formData = new FormData();
  const isMediaObject =
    isObjectLike(valueToAttach) &&
    valueToAttach.id &&
    valueToAttach.disk === "media";

  if (valueToAttach === undefined) {
    return;
  } else if (!isObjectLike(valueToAttach)) {
    formData.append(formDataKey, valueToAttach);
  } else if (valueToAttach instanceof dayjs) {
    formData.append(formDataKey, valueToAttach.toISOString());
  } else if (
    valueToAttach instanceof AppFile ||
    valueToAttach instanceof AppImage ||
    isMediaObject
  ) {
    if (valueToAttach.file) {
      formData.append(formDataKey, valueToAttach.file);
    }
  } else if (valueToAttach instanceof File || valueToAttach instanceof Blob) {
    formData.append(formDataKey, valueToAttach);
  } else {
    if (isFunction(valueToAttach.get)) {
      valueToAttach = valueToAttach.get();
    }

    for (const key in valueToAttach) {
      let subKey = formDataKey ? `${formDataKey}[${key}]` : key;
      attachToFormData(valueToAttach[key], subKey, formData);
    }
  }
  return formData;
}
