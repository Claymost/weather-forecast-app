<template>
    <div class="row">
        <div class="col-md-9 col-md-push-3 bg-color">.col-md-9 .col-md-push-3</div>
        <div class="col-md-3 col-md-pull-9">.col-md-3 .col-md-pull-9</div>
    </div>
    This is where we are going to add our template to do the things for sure
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  data() {
    return {
      count: 1
    }
  }
})
</script>

<style>
@text-color: @black-50;
</style>