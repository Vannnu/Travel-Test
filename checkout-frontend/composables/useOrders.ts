import { ref } from 'vue';

/**
 * Composable to manage order-related operations, including processing payments and creating orders.
 */
export const useOrders = () => {
    const error = ref<string | null>(null);

    /**
     * Processes a payment for a given cart.
     * @param {string} cartId - The ID of the cart to be paid for.
     * @param {string} paymentMethodId - The ID of the selected payment method.
     * @param {number} totalAmount - The total amount to be charged.
     * @returns {Promise<object | void>} The response JSON if successful, or sets an error message.
     */
    const processPayment = async (cartId: string, paymentMethodId: string, totalAmount: number): Promise<object | void> => {
        try {
            const response = await fetch('http://localhost:8080/payments/fake', {
                method: 'POST',
                body: JSON.stringify({
                    cart_id: cartId,
                    payment_method_id: paymentMethodId,
                    total_amount: totalAmount,
                }),
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Errore durante il processo di pagamento');
            }

            return await response.json();
        } catch (err) {
            error.value = err instanceof Error ? err.message : 'Errore Sconosciuto';
        }
    };

    /**
     * Creates an order after successful payment.
     * @param {string} cart_id - The ID of the cart being converted into an order.
     * @param {string} payment_method_id - The ID of the payment method used.
     * @param {string} transaction_id - The ID of the payment transaction.
     * @param {number} total_amount - The total amount of the order.
     * @returns {Promise<{ success: boolean, message: string }>} An object indicating success or failure with a message.
     */
    const createOrder = async (cart_id: string, payment_method_id: string, transaction_id: string, total_amount: number): Promise<{ success: boolean; message: string; }> => {
        try {
            const response = await fetch('http://localhost:8080/orders', {
                method: 'POST',
                body: JSON.stringify({
                    cart_id,
                    payment_method_id,
                    transaction_id,
                    total_amount,
                }),
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            const data = await response.json(); // Always extract JSON response

            if (!response.ok) {
                return { success: false, message: data.message || 'Errore nella creazione Ordine' };
            }

            return { success: true, message: 'Ordine Creato! Riceverai un email con il riepilogo dell\'Ordine' };
        } catch (err) {
            error.value = err instanceof Error ? err.message : 'Errore Sconosciuto';
            return { success: false, message: error.value };
        }
    };

    return {
        processPayment,
        createOrder,
        error,
    };
};
