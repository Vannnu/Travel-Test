<template>
  <header>
    <div class="menu">
      <router-link to="/" class="home-link">
        <i class="fas fa-home icon"></i>
      </router-link>
      <router-link @click.prevent="openModal" to="#" class="cart-link">
        <i :class="['fas', cartIconClass, 'icon']"></i>
      </router-link>
    </div>

    <div v-if="isModalVisible" class="modal-overlay">
      <div class="modal-content">
        <h3>Inserisci la tua Email per visualizzare il carrello</h3>
        <input v-model="emailInput" type="email" placeholder="Email" class="email-input" />
        <button @click="submitEmail" class="submit-button">Invia</button>
        <button @click="closeModal" class="cancel-button">Annulla</button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { useRouter } from 'vue-router';
const router = useRouter();
import { ref, computed } from 'vue';
import { useCart } from '@/composables/useCart';

const { isCartCreated, fetchCarts, email } = useCart();
const isModalVisible = ref(false);
const emailInput = ref('');

const cartIconClass = computed(() => {
  return isCartCreated.value ? 'fa-cart-plus' : 'fa-shopping-cart';
});

// Funzione per aprire il modale
const openModal = () => {
  isModalVisible.value = true;
};

const submitEmail = () => {
  if (emailInput.value) {
    email.value = emailInput.value;
    isModalVisible.value = false;
    router.push({
      name: 'cart',
      query: { email: email.value }
    });
  } else {
    error.value = 'Email non fornita';
  }
};

const closeModal = () => {
  isModalVisible.value = false;
};
</script>

<style scoped>
@import "@/assets/css/components/header.css";
</style>
