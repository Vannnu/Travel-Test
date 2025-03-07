<template>
  <div>
    <p v-if="isLoading">Caricamento carrello...</p>
    <p v-else-if="error">Errore: {{ error }}</p>
    <div v-else class="cart-items">
      <div v-for="cart in formattedCarts" :key="cart.name" class="cart-item">
        <div class="cart-image-container">
          <img v-if="cart.firstImage" :src="cart.firstImage" alt="Immagine viaggio" class="cart-image" />
          <button class="purchase-button" @click="openModal(cart)">Acquista</button>
        </div>

        <div class="cart-info">
          <h3 class="cart-title">{{ cart.name }}</h3>
          <p><strong>Prezzo Totale:</strong> €{{ cart.total_amount }}</p>
          <p><strong>Posti Riservati:</strong> {{ cart.reserved_seat }}</p>
          <p><strong>Partenza:</strong> {{ cart.starting_date }}</p>
          <p><strong>Ritorno:</strong> {{ cart.ending_date }}</p>
          <p><strong>Luogo di Partenza:</strong> {{ cart.departure_location }}</p>
        </div>
      </div>
    </div>

    <div v-if="isModalVisible" class="modal-overlay">
      <div class="modal-content">
        <h2 class="modal-title">Riepilogo Ordine</h2>

        <div v-if="isLoadingPayment" class="loading">
          <div class="spinner"></div>
          <p>Elaborazione pagamento...</p>
        </div>

        <div v-if="isLoadingPaymentMethods" class="loading">Caricamento...</div>
        <div v-else-if="errorPaymentMethods" class="error">Errore: {{ errorPaymentMethods }}</div>

        <div v-else class="payment-summary">
          <div class="summary-item">
            <span>Posti Riservati:</span>
            <span>{{ selectedCart.reserved_seat }}</span>
          </div>
          <div class="summary-item">
            <span>Prezzo Totale:</span>
            <span>€{{ selectedCart.total_amount }}</span>
          </div>
          <div class="summary-item">
            <span>Fee (2%):</span>
            <span>€{{ (selectedCart.total_amount * 0.02).toFixed(2) }}</span>
          </div>
          <div class="summary-item">
            <span>Tassa di Soggiorno:</span>
            <span>€20.00</span>
          </div>
          <div class="summary-item">
            <span>Varie & Eventuali:</span>
            <span>€100.00</span>
          </div>
          <div class="summary-item">
            <span><strong>Prezzo Finale:</strong></span>
            <span><strong>€{{ finalAmount }}</strong></span>
          </div>
        </div>

        <div class="payment-methods">
          <div v-for="method in paymentMethods" :key="method.id" class="payment-method">
            <input
                type="radio"
                :id="method.id"
                :value="method"
                v-model="selectedMethod"
                :disabled="!method.is_active"
            />
            <label :for="method.id" class="method-label">
              <img v-if="method.icon" :src="method.icon" alt="icon" class="method-icon" />
              <span>{{ method.name }}</span>
            </label>
          </div>
        </div>
        <button class="pay-button" @click="handlePayment">Paga</button>
        <button class="close-button" @click="closeModal">Annulla</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { usePaymentMethods } from '~/composables/usePaymentMethods.ts';
import { useCart } from '~/composables/useCart.ts';
import { useOrders } from '~/composables/useOrders.ts';

/**
 * Defines the reactive state and data fetching for the cart page.
 * - `carts`: List of cart data fetched from the API.
 * - `isLoading`: Indicates whether the cart data is still loading.
 * - `error`: Holds any error message related to cart fetching.
 */
const { carts, fetchCarts, isLoading, error } = useCart();

/**
 * Defines the reactive state and data fetching for payment methods.
 * - `isLoadingPaymentMethods`: Indicates whether payment methods are loading.
 * - `errorPaymentMethods`: Holds any error message related to payment methods fetching.
 * - `paymentMethods`: List of available payment methods.
 * - `fetchPaymentMethods`: Function to fetch the available payment methods.
 */
const { isLoadingPaymentMethods, errorPaymentMethods, paymentMethods, fetchPaymentMethods } = usePaymentMethods();

/**
 * Modal visibility state and cart selection state.
 * - `isModalVisible`: Controls the visibility of the payment modal.
 * - `selectedCart`: Stores the selected cart details for payment.
 * - `isLoadingPayment`: Indicates whether the payment is being processed.
 */
const isModalVisible = ref(false);
const selectedCart = ref(null);
const isLoadingPayment = ref(false);

/**
 * Get the email from the route query parameters.
 */
const route = useRoute();
const email = route.query.email;

/**
 * Computed property to format and prepare cart images and data.
 * - `formattedCarts`: Returns the carts with the first image parsed and added to the cart data.
 */
const formattedCarts = computed(() => {
  return carts.value.map(cart => {
    let images = [];

    try {
      images = JSON.parse(cart.url_images);
    } catch (err) {
      console.warn(`Errore nel parsing delle immagini per il carrello con id: ${cart.id}`, err);
    }

    return {
      ...cart,
      firstImage: images[0] || '', // Usa la prima immagine, se presente
    };
  });
});

/**
 * Fetch carts when the component is mounted.
 */
onMounted(() => {
  if (email) {
    fetchCarts(email);
  }
});

/**
 * Opens the modal for a selected cart and fetches payment methods.
 *
 * @param cart The cart to open the modal for.
 */
const openModal = (cart) => {
  selectedCart.value = cart;  // Popola selectedCart con il carrello selezionato
  isModalVisible.value = true; // Mostra il modale
  fetchPaymentMethods();       // Recupera i metodi di pagamento disponibili
};

/**
 * Closes the payment modal.
 */
const closeModal = () => {
  isModalVisible.value = false;
};

/**
 * Tracks the selected payment method.
 */
const selectedMethod = ref(null);

/**
 * Orders composable for handling order processes.
 */
const ordersComposable = useOrders();

/**
 * Computes the final amount after applying fees and additional charges.
 * - Includes a 2% fee, a fixed 20€ city tax, and a 100€ miscellaneous charge.
 */
const finalAmount = computed(() => {
  if (selectedCart.value) {
    return (selectedCart.value.total_amount * 1.02 + 20 + 100).toFixed(2);
  }
  return 0;
});

/**
 * Handles the payment process.
 * - Verifies selected method and cart.
 * - Simulates payment processing and sends request to create an order.
 */
const handlePayment = async () => {
  if (!selectedMethod.value || !selectedCart.value) {
    alert("Seleziona un metodo di pagamento e un carrello!");
    return;
  }

  isLoadingPayment.value = true;

  const cartId = selectedCart.value.id.toString();
  const paymentMethodId = selectedMethod.value.id;
  const totalAmount = finalAmount.value;

  if (!paymentMethodId) {
    alert("Devi selezionare un metodo di pagamento!");
    return;
  }

  try {
    await new Promise(resolve => setTimeout(resolve, 3000)); // Simula una chiamata di 3 secondi

    const response = await ordersComposable.processPayment(cartId, paymentMethodId, totalAmount);

    if (response) {
      const result = await ordersComposable.createOrder(cartId, paymentMethodId, response.transaction_id, response.total_amount);
      alert(result.message);
      removeCartFromUI(cartId);
    }
  } catch (error) {
    alert(`Si è verificato un errore durante il pagamento: ${error.message}`);
  } finally {
    isLoadingPayment.value = false;
    isModalVisible.value = false;
  }
}

/**
 * Removes a cart from the UI after successful payment.
 *
 * @param cartId The ID of the cart to remove.
 */
function removeCartFromUI(cartId) {
  carts.value = carts.value.filter(cart => cart.id !== cartId);
}
</script>

<style scoped>
@import "@/assets/css/pages/cart.css";
</style>
