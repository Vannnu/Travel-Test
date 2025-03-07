import { ref, type Ref } from 'vue';
import { useRouter } from 'vue-router';

// Define a type for the cart item
interface CartItem {
    email: string;
    reserved_seat: number;
    travel_id: string | number;
}

/**
 * Custom hook for managing cart-related operations.
 *
 * This hook provides methods for fetching cart data, adding items to the cart,
 * and managing loading states, errors, and success messages.
 *
 * @returns {Object} - The cart state and methods to interact with the cart.
 *
 * @property {Ref<boolean>} isLoading - Indicates whether the cart is being loaded.
 * @property {Ref<string | null>} error - Contains any error message that may occur during cart operations.
 * @property {Ref<string | null>} successMessage - Contains a success message when an item is successfully added to the cart.
 * @property {Ref<boolean>} isCartCreated - Indicates whether a cart has been successfully created.
 * @property {Ref<CartItem[]>} carts - List of the user's carts.
 * @property {Ref<string>} email - User's email address used to fetch or create carts.
 * @property {Function} fetchCarts - Fetches the carts associated with the user's email.
 * @property {Function} addToCart - Adds an item to the cart with specified parameters (email, reserved seat, travel ID).
 */
export const useCart = (): object => {
    const router = useRouter();

    // Reactive references with proper types
    const isLoading: Ref<boolean> = ref(false);
    const error: Ref<string | null> = ref(null);
    const successMessage: Ref<string | null> = ref(null);
    const isCartCreated: Ref<boolean> = ref(false);
    const carts: Ref<CartItem[]> = ref([]);  // Changed 'any' to the CartItem type
    const email: Ref<string> = ref('');

    /**
     * Fetches the carts associated with the user's email.
     *
     * @param {string} email - The user's email address.
     * @returns {Promise<void>} - A promise that resolves once the carts are fetched.
     */
    const fetchCarts = async (email: string): Promise<void> => {
        try {
            isLoading.value = true;
            const response = await fetch(`http://localhost:8080/carts?email=${encodeURIComponent(email)}`);
            if (!response.ok) throw new Error('Errore nel recupero del carrello');

            carts.value = await response.json();
        } catch (err) {
            error.value = err instanceof Error ? err.message : 'Errore sconosciuto';
        } finally {
            isLoading.value = false;
        }
    };

    /**
     * Adds an item to the cart.
     *
     * @param {string} email - The user's email address.
     * @param {number} reservedSeat - The number of reserved seats for the travel.
     * @param {string | number} travelId - The ID of the travel to be added to the cart.
     * @returns {Promise<void>} - A promise that resolves once the item is added to the cart.
     */
    const addToCart = async (email: string, reservedSeat: number, travelId: string | number): Promise<void> => {
        isLoading.value = true;
        error.value = null;
        successMessage.value = null;

        const cartData: CartItem = {
            email: email,
            reserved_seat: reservedSeat,
            travel_id: travelId,
        };

        console.log(JSON.stringify(cartData));

        try {
            const response = await fetch('http://localhost:8080/carts', {
                method: 'POST',
                body: JSON.stringify(cartData),
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                const responseData = await response.json();  // Get the JSON response body
                error.value = responseData.message;
            }

            successMessage.value = 'Carrello Aggiunto Con successo. I tuoi posti sono riservati per 15 minuti!';
            isCartCreated.value = true;
            router.push('/');
        } catch (err) {
            error.value = err instanceof Error ? err.message : 'Errore sconosciuto';
        } finally {
            isLoading.value = false;
        }
    };

    return {
        carts,
        isLoading,
        error,
        successMessage,
        isCartCreated,
        addToCart,
        fetchCarts,
        email,
    };
};
