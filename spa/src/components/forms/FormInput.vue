<template>
  <q-input
    v-if="type == 'text' || type == 'email' || type == 'number'"
    :rules="rules"
    filled
    dense
    :type="type"
    hide-bottom-space
    :model-value="modelValue"
    step="any"
    @update:model-value="emitValue"
  >
    <template v-for="(_, slot) in $slots" #[slot]="scope">
      <slot :name="slot" v-bind="{ ...scope }" />
    </template>
  </q-input>

  <q-input
    v-else-if="type == 'textarea'"
    filled
    dense
    :rules="rules"
    type="textarea"
    hide-bottom-space
    :model-value="modelValue"
    @update:model-value="emitValue"
  />

  <q-toggle
    v-else-if="type == 'switch'"
    checked-icon="check"
    color="green"
    unchecked-icon="clear"
    :model-value="modelValue"
    @update:model-value="emitValue"
  />

  <q-checkbox
    v-else-if="type == 'checkbox'"
    color="primary"
    :model-value="modelValue"
    @update:model-value="emitValue"
  />
</template>

<script setup>
const props = defineProps({
  modelValue: [String, Number, Boolean, Array],
  required: Boolean,
  type: {
    type: String,
    default: "text",
  },
});
const emit = defineEmits(["update:model-value"]);

const rules = props.required ? [(val) => !!val || "* Required"] : [];

const emitValue = (newVal) => {
  switch (props.type) {
    case "number":
      return emit("update:model-value", parseFloat(newVal));
    default:
      return emit("update:model-value", newVal);
  }
};
</script>
