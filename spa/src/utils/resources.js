import { startsWith } from "lodash-es";
import { appUrl } from "src/consts.js";

export function apiUrl(uri) {
  if (startsWith(uri, "http")) return uri;
  return `${appUrl}/api/${uri}`;
}

export function get(endpoint, params = []) {
  return window.axios
    .get(apiUrl(endpoint), { params })
    .then(({ data }) => data);
}

export function post(endpoint, data) {
  console.log(apiUrl(endpoint));
  return window.axios.post(apiUrl(endpoint), data).then(({ data }) => data);
}

export function put(endpoint, data) {
  return window.axios.get(apiUrl(endpoint), { data }).then(({ data }) => data);
}

export function save(endpoint, id, data, isResourceRoute = false) {
  if (!id) return post(endpoint, data);

  if (data instanceof FormData) {
    data.append("_method", "PUT");
  } else {
    data["_method"] = "PUT";
  }
  return post(isResourceRoute ? `${endpoint}/${id}` : endpoint, data);
}

export function destroy(endpoint, id, data) {
  return window.axios
    .delete(apiUrl(`${endpoint}/${id}`), { data })
    .then(({ data }) => data);
}
