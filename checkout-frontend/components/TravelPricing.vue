<template>
  <div class="travel-pricing">
    <p><i class="fas fa-euro-sign icon"></i> <strong>Prezzo:</strong> <span class="highlight">€{{ price.toFixed(2) }}</span></p>
    <p><i class="fas fa-users icon"></i> <strong>Posti Disponibili:</strong> <span class="highlight">{{ availableSeats }}</span></p>
    <p>
      <i class="fas fa-calendar-alt icon"></i>
      <strong>Partenza:</strong> {{ formatDate(starting_date) }} -
      <i class="fas fa-calendar-check icon"></i>
      <strong>Ritorno:</strong> {{ formatDate(ending_date) }}
    </p>
  </div>
</template>

<script setup>
defineProps({
  price: Number,
  availableSeats: Number,
  starting_date: String,
  ending_date: String
});

const formatDate = (date) => {
  if (!date) return "";
  return new Date(date).toLocaleDateString('it-IT', { day: '2-digit', month: 'long', year: 'numeric' });
};
</script>

<style scoped>
@import "@/assets/css/components/travel-pricing.css";
</style>