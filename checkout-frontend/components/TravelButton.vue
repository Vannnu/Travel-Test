<template>
  <div class="travel-button">
    <button @click="openModal">🛒 Aggiungi al Carrello</button>

    <div v-if="showModal" class="modal-overlay">
      <div class="modal">
        <h3>Aggiungi al Carrello</h3>
        <form @submit.prevent="submitForm">
          <div>
            <label for="email">Email: </label>
            <input type="email" id="email" v-model="email" required />
          </div>
          <div>
            <label for="seats">Posti: </label>
            <input
                type="number"
                id="seats"
                v-model="seats"
                :max="availableSeats"
                min="1"
                required
            />
          </div>
          <button type="submit" :disabled="isLoading">Aggiungi</button>
          <button type="button" @click="closeModal">Chiudi</button>
        </form>

        <p v-if="error" class="error">{{ error }}</p>
        <p v-if="successMessage" class="success">{{ successMessage }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useCart } from '@/composables/useCart.ts';

const { addToCart, isLoading, error, successMessage } = useCart();
const email = ref('');
const seats = ref(1);
const showModal = ref(false);
const props = defineProps({
  travelId: {
    type: [String, Number],
    required: true
  },
  availableSeats: {
    type: Number,
    required: true
  }
});

const openModal = () => {
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  email.value = '';
  seats.value = 1;
  error.value = '';
  successMessage.value = '';
};

const submitForm = async () => {
  error.value = '';
  successMessage.value = '';

  await addToCart(email.value, seats.value, props.travelId);

  if (error.value) {
    alert(error.value);
  } else {
    successMessage.value = successMessage.value || 'Aggiunto con successo!';
    alert(successMessage.value);
    closeModal();
  }
};
</script>

<style scoped>
@import "@/assets/css/components/travel-button.css";
</style>
