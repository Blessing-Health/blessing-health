<template>
  <q-card flat>
    <q-card-section>
      <div class="row q-col-gutter-x-lg item-center">
        <div class="col-12">
          <div class="row q-col-gutter-xs justify-end">
            <slot name="summary" />
          </div>
        </div>
      </div>
    </q-card-section>
  </q-card>
</template>

<script setup></script>
