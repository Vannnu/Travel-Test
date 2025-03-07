<template>
  <div v-if="isLoading">Caricamento...</div>
  <div v-else-if="error">{{ error }}</div>
  <div v-else>
    <TravelGallery :images="travel?.url_images" />
    <TravelPricing :price="travel?.price"
                   :availableSeats="travel?.seat_capacity - travel?.reserved_seat_number"
                   :starting_date="travel?.starting_date"
                   :ending_date="travel?.ending_date"
    />
    <TravelButton :travelId="travel?.id"
                  :availableSeats="travel?.seat_capacity"
    />
    <TravelDescription :description="travel?.description" />
    <TravelMoods :moods="travel?.moods" />
    <TravelServices :services="travel?.description" />
    <TravelItinerary :itinerary="travel?.description" />
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router';
import { useTravelDetails } from '@/composables/useTravelDetails';
import TravelDescription from '@/components/TravelDescription.vue';
import TravelServices from '@/components/TravelServices.vue';
import TravelItinerary from '@/components/TravelItinerary.vue';
import TravelPricing from '@/components/TravelPricing.vue';
import TravelButton from '@/components/TravelButton.vue';

const route = useRoute();
const { travel, isLoading, error } = useTravelDetails(route.params.id);
</script>

<style scoped>
@import "@/assets/css/pages/travel.css";
</style>
