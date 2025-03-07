<template>
  <div>
    <p v-if="isLoading">Caricamento in corso...</p>
    <p v-else-if="error">Errore: {{ error }}</p>
    <div v-else class="travel-list">
      <router-link
          v-for="travel in travels"
          :key="travel.id"
          :to="`/travel/${travel.id}`"
          class="travel-link"
      >
        <div class="travel-card">
          <h3 class="travel-title">{{ travel.title }}</h3>

          <div class="travel-content">
            <div class="travel-image-container">
              <img :src="travel.image" alt="Travel Image" class="travel-image" />
            </div>
            <div class="travel-info">
              <p><strong>Descrizione:</strong> {{ travel.description }}</p>
              <p><strong>A Partire Da:</strong> €{{ travel.price }}</p>
              <p><strong>Posti disponibili:</strong> {{ travel.availableSeats }}</p>
            </div>
          </div>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useTravels } from '@/composables/useTravels';

/**
 * State variables and function for fetching travels.
 *
 * - `travels`: Array of travel data.
 * - `isLoading`: Indicates if the data is still loading.
 * - `error`: Holds any error messages encountered during data fetch.
 */
const { travels, isLoading, error } = useTravels();
</script>

<style scoped>
@import '@/assets/css/pages/index.css';
</style>