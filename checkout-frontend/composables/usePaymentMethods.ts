import { ref } from 'vue';

/**
 * A composable to manage payment methods in the application.
 * It provides functionality to fetch available payment methods from an API.
 */
export const usePaymentMethods = () => {
    const paymentMethods = ref([]); // Holds the list of payment methods
    const isLoading = ref(true); // Indicates whether the data is being fetched
    const error = ref<string | null>(null); // Stores any error messages

    /**
     * Fetches the list of available payment methods from the API.
     * If the request fails, an error message is stored.
     */
    const fetchPaymentMethods = async () => {
        try {
            const response = await fetch('http://localhost:8080/payments'); // Cambia con il tuo endpoint API

            if (response.ok) {
                paymentMethods.value = await response.json();
            } else {
                throw new Error('Errore nel recupero dei metodi di pagamento');
            }
        } catch (err) {
            error.value = err instanceof Error ? err.message : 'Errore sconosciuto';
        } finally {
            isLoading.value = false;
        }
    };

    return {
        paymentMethods,
        isLoading,
        error,
        fetchPaymentMethods
    };
};
