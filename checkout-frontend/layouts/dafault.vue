<!-- layouts/default.vue -->
<template>
  <div class="layout-container">
    <header>
      <div class="menu">
        <div class="search">
          <font-awesome-icon icon="search" />
          <input type="text" placeholder="Cerca..." />
        </div>
        <div class="right-menu">
          <router-link to="/contact">Contattaci</router-link>
          <router-link to="/cart">Carrello</router-link>
          <div class="language-selector">Lingua</div>
        </div>
      </div>
    </header>

    <main>
      <NuxtLayout />
    </main>

    <footer>
      <p>&copy; 2025 Viaggi Inc. | Tutti i diritti riservati</p>
    </footer>
  </div>
</template>

<script setup lang="ts">
import '@/assets/css/layouts/default.css';
</script>

