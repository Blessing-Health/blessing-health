<template>
  <q-card flat>
    <q-card-section>
      <div class="row q-col-gutter-x-lg item-center">
        <div class="col-12">
          <div class="row q-col-gutter-xs justify-end">
            <slot name="summary" v-bind="lastResponse" />
          </div>
        </div>
        <div class="col-12 col-xs-auto">
          <q-input
            v-model="quicksearch"
            borderless
            dense
            placeholder="Search"
            :autofocus="!noAutofocus"
          >
            <template #append>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>
        <div class="col-12 col-xl">
          <div class="row q-col-gutter-xs justify-end">
            <slot name="controls" />
          </div>
        </div>
      </div>
    </q-card-section>
    <div style="height: 2px">
      <q-linear-progress v-if="isLoading" indeterminate size="2px" />
    </div>
    <q-markup-table class="q-mb-none" bordered flat wrap-cells>
      <thead>
        <tr>
          <datatable-column-header
            v-for="col in visibleColumns"
            :key="col.name"
            :col="col"
            :pagination="pagination"
            @reload="fetchData"
          />
        </tr>
      </thead>
      <tbody>
        <tr v-for="row in rows" :key="row[rowKey]">
          <td
            v-for="col in visibleColumns"
            :key="col.name"
            :class="col.classes"
          >
            <component
              v-if="col.renderComponent"
              :is="col.renderComponent"
              :value="row[col.field]"
              :row="row"
              :column="col"
            />
            <slot
              v-else
              :name="`column-${col.field}`"
              :value="row[col.field]"
              :row="row"
              :column="col"
            >
              {{
                col.format ? col.format(row[col.field], row) : row[col.field]
              }}
            </slot>
          </td>
        </tr>
      </tbody>
    </q-markup-table>
    <datatable-pagination
      v-if="totalRows > pagination.take"
      :pagination="pagination"
      :total-rows="totalRows"
      @reload="fetchData"
    >
      <slot name="pagination-left-section" />
    </datatable-pagination>
    <div v-else-if="!totalRows && !isLoading" class="row justify-center">
      <placeholder> No matching records found </placeholder>
    </div>
  </q-card>
</template>

<script setup>
import DatatableColumnHeader from "./DatatableColumnHeader.vue";
import DatatablePagination from "./DatatablePagination.vue";
import RowSelectionRenderer from "./renderers/RowSelectionRenderer.vue";
import { computed, isReactive, onMounted, reactive, ref, watch } from "vue";
import { get } from "../../utils/resources.js";
import { debounce } from "lodash-es";
import { actionsColumn } from "./datatableColumnBuilder.js";
console.log(23);

const props = defineProps({
  url: String,
  columns: Array,
  columnVisibilities: Object, // Bulk toggle whether each column should be visible or not
  sendData: Object, // Additional params to send up with request to fetch table data (watched for changes). Should be a vue reactive object
  paginationDefaults: Object, // Override default paging settings
  noAutofocus: Boolean, // Disable autofocus of the quicksearch input
  noFilterControls: Boolean, // Hide the search box and any table filters
  selectionMap: Object, // A reactive object holding rows that have been selected by the user. Providing this prop will enable row selection behaviour for the table
  rowKey: {
    type: String,
    default: "id", // Value in each row data to use to uniquely identify each row
  },
});

console.log(props);
const isLoading = ref(true);
const quicksearch = ref();
const totalRows = ref(0);
const lastResponse = ref({});
const pagination = reactive({
  sort_by: "id",
  descending: false,
  page: 1,
  take: 15,
  ...props.paginationDefaults,
});

const rows = ref([]);

const selectionColumn = props.selectionMap
  ? actionsColumn("select").setRendererComponent(RowSelectionRenderer)
  : null;

const visibleColumns = computed(() => {
  let columns = props.columns.slice();
  if (props.selectionMap) columns.unshift(selectionColumn);
  return columns.filter(
    (col) => props.columnVisibilities?.[col.field] !== false && col.visible
  );
});

// Fetch data from the server (server must return a DatatableBuilder response)
const fetchData = async () => {
  isLoading.value = true;

  const response = await get(props.url, {
    ...props.sendData,
    quicksearch: quicksearch.value,
    ...pagination,
    skip: (pagination.page - 1) * pagination.take,
  });

  // Replace existing table rows
  rows.value.splice(0, rows.value.length, ...response.data);
  totalRows.value = response.total;
  lastResponse.value = response;
  isLoading.value = false;
};

const fetchDataDebounced = debounce(fetchData, 500);

// When user starts typing show loading straight away, but let changes settle (debounce) before hitting the server
watch(quicksearch, () => {
  isLoading.value = true;
  fetchDataDebounced();
});

if (isReactive(props.sendData)) watch(props.sendData, fetchDataDebounced);
watch(() => props.url, fetchDataDebounced);

onMounted(fetchData);

// To let parent component able to re-fetch that page if edited a record in a Modal
defineExpose({ fetchData });
</script>
