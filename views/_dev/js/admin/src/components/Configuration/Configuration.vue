<template>
  <div class="w-100">
    <notification></notification>

    <div class="row">
      <div class="col-6">
        <top-description></top-description>
      </div>
      <div class="col-6">
        <cache></cache>
      </div>
    </div>

    <div class="w-100">
      <router-view></router-view>
    </div>
  </div>
</template>

<script src="./configuration.js">
</script>

<style scoped>

</style>