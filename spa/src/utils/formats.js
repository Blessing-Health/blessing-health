import { kebabCase } from "lodash-es";

/**
 * Formatting helper functions
 */

export function number(val, dp = 0) {
  return Intl.NumberFormat(undefined, {
    maximumFractionDigits: dp,
    minimumFractionDigits: dp,
  }).format(val || 0);
}

export function numberWithOptionalDecimals(val, dp = 2) {
  return Intl.NumberFormat(undefined, {
    maximumFractionDigits: dp,
    minimumFractionDigits: 0,
  }).format(val || 0);
}

export function currency(val, mantissa = 2) {
  // eslint-disable-next-line no-irregular-whitespace
  return `$${number(val, mantissa)}`;
}

export function shortNumber(val) {
  if (val > 1000000) return `${number(val / 1000000, 1)}m`;
  if (val > 1000) return `${number(val / 1000, 1)}k`;
  return number(val);
}

export function percent(val, dp = 0) {
  return `${number(val * 100, dp)}%`;
}

export function bytes(bytes, decimals = 1) {
  if (!bytes) return "0 Bytes";

  const k = 1024;
  const dm = decimals < 0 ? 0 : decimals;
  const sizes = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];

  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
}

export function time(val, format = "h:mm A") {
  if (!val) return "";

  if (!(val instanceof dayjs)) val = dayjs(val);
  return val.format(format);
}

export function date(val, format = "DD/MM/YYYY") {
  if (!val) return "";

  if (!(val instanceof dayjs)) val = dayjs(val);
  return val.format(format);
}

export function dateTime(val) {
  return date(val, "h:mm A DD/MM/YYYY");
}

export function longDate(val) {
  return date(val, "ddd Do MMM YYYY");
}

export function longDateTime(val) {
  return date(val, "h:mmA, ddd Do MMM YYYY");
}

export function sqlDate(val) {
  return date(val, "YYYY-MM-DD");
}

export function sqlTime(val) {
  return date(val, "HH:mm:ss");
}

export function sqlTimestamp(val = null) {
  return date(val || dayjs(), "YYYY-MM-DD HH:mm:ss");
}

export function shortTimeAgo(val) {
  if (!(val instanceof dayjs)) {
    val = dayjs(val);
  }
  let days = dayjs().diff(val, "days");
  return days > 365
    ? `${Math.round(days / 365)}y` // in # years
    : `${days}d`; // in # days
}

export function timestamp(val) {
  if (!(val instanceof dayjs)) val = dayjs(val);
  return val.fromNow();
}

/**
 * Just a relative timestamp without a time component
 */
export function datestamp(val) {
  if (!(val instanceof dayjs)) val = dayjs(val);

  let days = val.diff(dayjs().startOf("day"), "days");
  switch (days) {
    case 0:
      return "today";
    case 1:
      return "tomorrow";
    case -1:
      return "yesterday";
    default:
      return dayjs.duration(days, "days").humanize(true);
  }
}

export function mailTo(email, subject) {
  let mailto = `mailto:${email}`;
  if (subject) {
    mailto += `?subject=${subject}`;
  }
  return mailto;
}

export function slug(str) {
  if (!str) return "";
  return kebabCase(str.toLowerCase());
}

export function plural(singluarForm, pluralForm, count) {
  return count == 1 ? singluarForm : pluralForm;
}
