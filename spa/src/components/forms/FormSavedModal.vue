<template>
  <q-dialog
    :model-value="show"
    persistent
    @update:model-value="emit('update:show', false)"
  >
    <q-card style="width: 80vw">
      <q-item class="q-py-md bg-accent text-white">
        <q-item-section side>
          <q-icon
            color="white"
            name="done"
            size="md"
            class="animated bounceInDown"
            style="animation-duration: 600ms"
          />
        </q-item-section>

        <q-item-section>
          <div class="text-h4">{{ entityTypeName }} Saved!</div>
        </q-item-section>
      </q-item>

      <q-card-section> What would you like to do next? </q-card-section>

      <q-card-actions align="center" class="q-py-md">
        <q-btn
          v-if="redirectAfterSave"
          label="View Details"
          icon="search"
          color="primary"
          no-caps
          @click="redirectAfterSave(saveResult)"
        />

        <q-btn
          v-if="canAddAnother"
          label="Add Another"
          icon="add"
          color="accent"
          no-caps
          @click="emit('add-another')"
        />
        <back-button color="secondary" :flat="false" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script setup>
defineProps({
  show: Boolean,
  saveResult: null, // Any data that came back from the server after saving
  entityTypeName: String, // Pre-translated name of the entity this form is working with. e.g "Location"
  redirectAfterSave: Function, // Optional custom callback to view details about the entity after saving
  canAddAnother: Boolean, // Show the button to "Add another" of the same entity
});

const emit = defineEmits(["update:show", "add-another"]);
</script>
