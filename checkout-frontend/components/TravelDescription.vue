<template>
  <div class="travel-description">
    <h4>{{ description.text }}</h4>

    <h3 class="highlights-title">Punti Salienti:</h3>
    <ul class="highlights-list">
      <li v-for="highlight in description.highlights" :key="highlight" class="highlight-item">
        <span class="icon">🌍</span> {{ highlight }}
      </li>
    </ul>

    <p><strong>Livello di difficoltà:</strong> <span class="difficulty">{{ description.difficulty_level }}</span></p>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
const props = defineProps({
  description: {
    type: Object,
    required: true
  }
});
onMounted(() => {
  console.log(props.description);
});
</script>

<style scoped>
@import "@/assets/css/components/travel-description.css";
</style>