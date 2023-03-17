import { startCase, isArray } from "lodash-es";
import { markRaw } from "vue";

/**
 * Return a new datatable column which can be used for chaining
 */
export function column(name = "id", label) {
  return new DatatableColumn(name, label);
}

/**
 * Creates a special column used for row action buttons
 */
export function actionsColumn(field = "actions") {
  return column(field)
    .setUnsortable()
    .setCompact()
    .setCenter()
    .setClasses("actions text-center");
}

/**
 * Creates a special column used for row selection
 */
export function selectionColumn() {
  return actionsColumn("selection");
}

/**
 * Structure to represent the column information to be fed into the datatable
 */
class DatatableColumn {
  constructor(field, label = "") {
    this.field = field;
    this.label = label || startCase(field);
    this.align = "left";
    this.headerStyle = undefined;
    this.classes = [];
    this.sortable = true;
    this.visible = true;

    this.format = undefined;
    this.renderComponent = null;
  }

  /**
   * Center align this column
   */
  setCenter() {
    this.align = "center";
    this.classes.push("text-center");
    return this;
  }

  /**
   * Set custom styling to apply to the column header <th>
   */
  setHeaderStyle(key, value) {
    if (!this.headerStyle) this.headerStyle = {};
    this.headerStyle[key] = value;
    return this;
  }

  /**
   * Set a class or array of classes to apply to the column (both <th> and <td>)
   */
  setClasses(classes) {
    this.classes = isArray(classes) ? classes : [classes];
    return this;
  }

  /**
   * Max this column width as small as possible
   */
  setCompact() {
    this.setHeaderStyle("width", "1px");
    return this;
  }

  /**
   * Disable sorting on this column (useful for calculated clientside only columns)
   */
  setUnsortable() {
    this.sortable = false;
    return this;
  }

  /**
   * Toggle whether the entire column should be visible
   */
  setVisible(isVisible) {
    this.visible = isVisible;
    return this;
  }

  /**
   * Hide this column on small-sized screens (xs)
   */
  hideOnTinyScreens() {
    this.classes.push("gt-xs");
    return this;
  }

  /**
   * Hide this column on medium-sized screens or lower (xs, sm, md)
   */
  hideOnMediumScreens() {
    this.classes.push("gt-md");
    return this;
  }

  /**
   * Run a function to produce a custom formatted value.
   * Callback function is provided with 2 params: 'val' and 'row'
   * https://quasar.dev/vue-components/table#defining-the-columns
   */
  setCustomFormatter(fn) {
    this.format = fn;
    return this;
  }

  /**
   * Manually set a specific component to use for rendering this column
   */
  setRendererComponent(component) {
    this.renderComponent = markRaw(component);
    return this;
  }
}
