<template>
  <div class="travel-services">
    <h3>Servizi Inclusi</h3>
    <ul class="included">
      <li v-for="service in services.included_services" :key="service" class="service-item">
        <span class="check-icon">✔️</span> {{ service }}
      </li>
    </ul>

    <h3>Servizi Esclusi</h3>
    <ul class="excluded">
      <li v-for="service in services.excluded_services" :key="service" class="service-item">
        <span class="cross-icon">❌</span> {{ service }}
      </li>
    </ul>
  </div>
</template>

<script setup>
defineProps({
  services: Object
});
</script>

<style scoped>
@import "@/assets/css/components/travel-services.css";
</style>