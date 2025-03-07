<template>
  <div class="gallery">
    <div class="main-image">
      <img :src="images[currentIndex]" alt="Main Travel image" />
    </div>
    <div class="thumbnail-container">
      <img
          v-for="(image, index) in images"
          :key="index"
          :src="image"
          alt="Thumbnail"
          class="thumbnail"
          @click="changeMainImage(index)"
          :class="{ active: currentIndex === index }"
      />
    </div>
  </div>
</template>

<script setup>
defineProps({
  images: Array
});

const currentIndex = ref(0);
const changeMainImage = (index) => {
  currentIndex.value = index;
};
</script>

<style scoped>
@import "@/assets/css/components/travel-gallery.css";
</style>