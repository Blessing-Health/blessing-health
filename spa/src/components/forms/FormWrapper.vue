<template>
  <q-page>
    <slide-transition vertical>
      <q-form v-if="!appStore.isLoading" ref="$form" greedy @submit="onSubmit">
        <div class="row q-col-gutter-x-md">
          <div class="col-12 q-gutter-y-md" :class="`col-xl-${formWidth}`">
            <slot />
            <form-section>
              <div class="q-gutter-x-sm flex">
                <save-button
                  :disable="disableSave || isSaving"
                  :is-saving="isSaving"
                  :what="entityTypeName"
                />
                <slot name="buttons" />
                <back-button :disable="isSaving" form />
                <!-- <delete-button
                  v-if="props.delete && isEditing"
                  :disable="disableDelete || isSaving"
                  :what="entityTypeName"
                  :no-confirm="useCustomDeleteConfirmation"
                  :delete="deleteEntity"
                  class="q-ml-auto"
                /> -->
              </div>
            </form-section>
          </div>

          <div class="col-12 q-gutter-y-md" :class="`col-xl-${12 - formWidth}`">
            <slot name="form-side" />
          </div>

          <form-saved-modal
            v-model:show="showSavedModal"
            :entity-type-name="entityTypeName"
            :redirect-after-save="redirectAfterSave"
            :can-add-another="canAddAnother"
            :save-result="saveResult"
            @add-another="onAddAnother"
          />
        </div>
      </q-form>
    </slide-transition>
  </q-page>
</template>

<script setup>
import SlideTransition from "src/components/interactions/SlideTransition.vue";
import FormSavedModal from "./FormSavedModal.vue";
import { useAppStore } from "src/stores/appStore.js";
// import { confirmFormLeave } from "src/utils/dialogs.js";
import { computed, nextTick, onMounted, ref, watch } from "vue";
import { onBeforeRouteLeave, useRouter } from "vue-router";
import { Notify } from "quasar";
import { isFunction } from "lodash-es";
import pluralize from "pluralize";

const props = defineProps({
  form: Object, // The actual form data
  save: Function, // How to save this form (should return a promise)
  load: Function, // How to load supporting data for the form. Return FALSE to bail out and automatically redirect back
  delete: Function, // How to delete the entity (needs to return a route to redirect to)
  addAnother: [Boolean, Function], // Enable ability to "add another". Pass callback to control how form data should be reset.

  // Type of the entity this form is working with. e.g "User"
  entityTypeName: {
    type: String,
    default: "{missing}",
  },

  // A key from the provided form data that best describes the name of the entity being edited
  entityNameKey: {
    type: String,
    default: "name",
  },

  sectionName: String, // Set the section name for the page title
  listingRoute: [String, Object], // Optional route to go to view a listing of this type of entity
  redirectAfterSave: Function, // Callback to handle where to redirect to after saving. Is provided with the save response data from the server
  customPageDescription: String, // Override the default page description text
  useCustomDeleteConfirmation: Boolean, // Set to true if wanting to show own before-delete-confirmation with more detail
  disableSave: Boolean, // Disable the main save button
  disableDelete: Boolean, // Disable the delete button
  customPageInfo: Boolean, // Set to true if manually wanting to set the page info
  customAddIcon: String,

  // How wide to make the form on large screens
  formWidth: {
    type: Number,
    default: 8, // Quasar grid column sizing
  },
});

const appStore = useAppStore();
appStore.setLoading(true);

const router = useRouter();
const $form = ref(null); // Reference to the actual q-form instance once it has been loaded

const showSavedModal = ref(false);
const isSaving = ref(false);
const isEditing = computed(() => !!props.form.id);
const changeDetectionEnabled = ref(false);
const hasUnsavedChanges = ref(false);
const canAddAnother = computed(() => props.addAnother && !isEditing.value);
const saveResult = ref(); // The data that came back from the server after saving (typically just an ID)

// Watch for form changes to prevent data loss due to accidental navigation
watch(
  () => props.form,
  () => {
    if (!changeDetectionEnabled.value) return;
    hasUnsavedChanges.value = true;
  },
  { deep: true }
);

onMounted(async () => {
  if (props.load) {
    try {
      await props.load();
    } catch (err) {
      router.back(); // Failed to load for some reason (error already shown) bail out
      throw err;
    }
  }

  // Automatically set some suitable defaults for the page info/title?
  if (!props.customPageInfo) {
    appStore.setPageInfo({
      title: isEditing.value
        ? `Editing ${props.entityTypeName}`
        : `New ${props.entityTypeName}`,
      section: props.sectionName,
      subtitle:
        props.customPageDescription || isEditing.value
          ? `Use this form to update the details of ${
              props.form[props.entityNameKey] || props.entityTypeName
            }`
          : `Fill in this form to create a new ${props.entityTypeName}`,
      icon: isEditing.value
        ? "edit"
        : props.customAddIcon
        ? props.customAddIcon
        : "person_add",

      // Include listing route in breadcrumbs if one is available
      breadcrumbs: props.listingRoute
        ? [
            {
              label: pluralize.plural(props.entityTypeName),
              to: props.listingRoute,
            },
          ]
        : [],

      officeId: "auto",
    });
  }

  appStore.setIsFillingOutForm(true);
  appStore.setLoading(false);

  // Wait a little bit before enabling change detection so that async or cascading changes settle first
  setTimeout(() => (changeDetectionEnabled.value = true), 1000);
});

// Submit the form (validation will have already passed)
const onSubmit = async () => {
  // let parent component do the actual saving...
  isSaving.value = true;
  saveResult.value = await props
    .save(props.form)
    .finally(() => (isSaving.value = false));

  // Something went wrong saving? Dont redirect. This is usually just for development purposes such as dd() on server
  if (saveResult.value === false) return;

  hasUnsavedChanges.value = false;

  // Ask the user what they want to do next?
  if (canAddAnother.value) {
    showSavedModal.value = true;
  } else {
    Notify.create({
      title: "Success",
      message: `The ${props.entityTypeName.toLowerCase()} was saved successfully`,
      color: "positive",
      icon: "done",
    });

    if (props.redirectAfterSave) props.redirectAfterSave(saveResult.value);
    else router.back();
  }
};

const onAddAnother = async () => {
  // Ask the parent component to reset any other form data as necessary
  if (isFunction(props.addAnother)) await props.addAnother();

  // Should always reset these form fields as well
  props.form.uuid = null;
  props.form.is_dirty = false;
  props.form.last_updated_by = null;

  hasUnsavedChanges.value = false;
  showSavedModal.value = false;

  nextTick(() => {
    window.scrollTo({ top: 0, behavior: "smooth" });
    $form.value?.focus();
  });
};

const deleteEntity = async () => {
  let redirectTo = await props.delete(); // Let parent component handle the actual deleting (should return a route to redirect to)
  if (redirectTo === false) return false; // Unable to delete? Just bail

  hasUnsavedChanges.value = false; // prevent unsaved changes popup from showing

  if (redirectTo) return router.replace(redirectTo);
  router.back();
};

// Provide a way for parent component to manually clear the unsaved changes flag if needed
const clearHasUnsavedChangesFlag = () => (hasUnsavedChanges.value = false);
defineExpose({ clearHasUnsavedChangesFlag });

// onBeforeRouteLeave((to, from, next) => {
//   confirmFormLeave(hasUnsavedChanges.value, next);

//   appStore.setIsFillingOutForm(false);
// });
</script>
