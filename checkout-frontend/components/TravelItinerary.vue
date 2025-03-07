<template>
  <div class="travel-itinerary">
    <h3>Itinerario</h3>
    <div class="itinerary-grid">
      <div v-for="(day, index) in itinerary.itinerary" :key="index" class="grid-item">
        <div class="day-box">
          <span class="day-number">{{ index }}</span>
          <p class="day-description">{{ day }}</p>
        </div>
      </div>
    </div>

    <h3>Guida</h3>
    <div class="guide-card">
      <i class="fas fa-user guide-icon"></i>
      <p class="guide-text">{{ itinerary.guide }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  itinerary: Object
});
</script>

<style scoped>
@import "@/assets/css/components/travel-itinerary.css";
</style>