<script setup lang="ts">
defineProps<{
  travel: {
    id: string;
    title: string;
    description: string;
    price: number,
    url_images: string
  }
}>();
</script>

<template>
  <div class="travel-card">
    <h2>{{ travel.title }}</h2>
    <p>{{ travel.description }}</p>
    <p class="price">€{{ travel.price.toFixed(2) }}</p>
  </div>
</template>

<style scoped>
@import "@/assets/css/components/travel-card.css";
</style>