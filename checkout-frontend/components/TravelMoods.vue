<template>
  <div class="moods">
    <div v-for="(value, key) in moods" :key="key" class="mood-item">
      <div class="mood-icon">
        <i v-if="key === 'nature'" class="fas fa-tree" style="color: #4CAF50;"></i> <!-- Verde per Natura -->
        <i v-if="key === 'relax'" class="fas fa-bed" style="color: #FFB74D;"></i> <!-- Arancione per Relax -->
        <i v-if="key === 'history'" class="fas fa-landmark" style="color: #3F51B5;"></i> <!-- Blu per Storia -->
        <i v-if="key === 'culture'" class="fas fa-theater-masks" style="color: #9C27B0;"></i> <!-- Viola per Cultura -->
        <i v-if="key === 'party'" class="fas fa-cocktail" style="color: #FF4081;"></i> <!-- Rosa per Vita Notturna -->
      </div>
      <div class="mood-progress">
        <div class="circle">
          <div class="circle-progress" :style="{ background: 'conic-gradient(' + getTortaColor(key) + ' ' + value + '%, #ddd ' + value + '%)' }">
            <span class="percentage">{{ value }}%</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  moods: Object
});

const getTortaColor = (key) => {
  const colors = {
    nature: '#4CAF50',
    relax: '#FFB74D',
    history: '#3F51B5',
    culture: '#9C27B0',
    party: '#FF4081'
  };
  return colors[key] || '#007bff'
};
</script>

<style scoped>
@import "@/assets/css/components/travel-mood.css";
</style>